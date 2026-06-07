<?php
/**
 * submit-form.php
 * Обработка заявок с форм сайта АкваМед
 * Защита: PDO prepared statements, валидация, rate-limit, XSS
 */

// ---------- Заголовки ----------
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Только POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Метод не поддерживается']);
    exit;
}

require_once __DIR__ . '/../includes/db.php';

$response = ['success' => false, 'message' => '', 'errors' => []];

try {
    // ========== 1. ПОЛУЧЕНИЕ ДАННЫХ ==========
    $raw = file_get_contents('php://input');
    $input = $raw ? json_decode($raw, true) : null;

    // Fallback на обычный POST
    if (!is_array($input) || empty($input)) {
        $input = $_POST;
    }

    // ========== 2. САНИТИЗАЦИЯ (только trim, без htmlspecialchars — это для вывода) ==========
    $name    = isset($input['name'])    ? mb_substr(trim($input['name']),    0, 100) : '';
    $phone   = isset($input['phone'])   ? mb_substr(trim($input['phone']),   0, 30)  : '';
    $email   = isset($input['email'])   ? mb_substr(trim($input['email']),   0, 100) : '';
    $message = isset($input['message']) ? mb_substr(trim($input['message']), 0, 2000): '';

    // ========== 3. ВАЛИДАЦИЯ ==========

    // Имя
    if ($name === '') {
        $response['errors']['name'] = 'Пожалуйста, введите ваше имя';
    } elseif (mb_strlen($name) < 2) {
        $response['errors']['name'] = 'Имя должно содержать минимум 2 символа';
    } elseif (!preg_match('/^[\p{L}\s\-\.]+$/u', $name)) {
        $response['errors']['name'] = 'Имя содержит недопустимые символы';
    }

    // Телефон
    if ($phone === '') {
        $response['errors']['phone'] = 'Пожалуйста, введите номер телефона';
    } else {
        $phoneClean  = preg_replace('/[^0-9+]/', '', $phone);
        $digitsOnly  = preg_replace('/[^0-9]/', '', $phoneClean);
        if (strlen($digitsOnly) < 10) {
            $response['errors']['phone'] = 'Номер телефона слишком короткий (минимум 10 цифр)';
        } elseif (strlen($digitsOnly) > 15) {
            $response['errors']['phone'] = 'Номер телефона слишком длинный';
        } else {
            $phone = $phoneClean; // нормализованный
        }
    }

    // Email (необязательный)
    if ($email !== '') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['errors']['email'] = 'Введите корректный email адрес';
        }
    }

    // Если есть ошибки — возвращаем
    if (!empty($response['errors'])) {
        $response['message'] = 'Пожалуйста, исправьте ошибки в форме';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // ========== 4. RATE LIMIT: не чаще 1 заявки в 5 минут ==========
    $db = Database::getInstance();

    $existing = $db->fetchOne(
        "SELECT id, created_at
         FROM applications
         WHERE (phone = :phone OR (:email_check != '' AND email = :email_val))
           AND created_at >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)
           AND status != 'cancelled'
         LIMIT 1",
        [':phone' => $phone, ':email_check' => $email ?: '', ':email_val' => $email ?: '']
    );

    if ($existing) {
        $created     = new DateTime($existing['created_at']);
        $waitSeconds = 300 - (time() - $created->getTimestamp());
        $waitMin     = (int) ceil(max($waitSeconds, 60) / 60);

        $response['message'] = sprintf(
            'Вы уже отправляли заявку в %s. Повторите через %d %s.',
            $created->format('H:i'),
            $waitMin,
            pluralForm($waitMin, 'минуту', 'минуты', 'минут')
        );
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // ========== 5. ОПРЕДЕЛЕНИЕ IP ==========
    $ip = null;
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Берём только первый IP из списка (прокси могут добавлять несколько)
        $ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // Валидируем IP
    if ($ip && !filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = null;
    }

    // ========== 6. СОХРАНЕНИЕ В БД ==========
    // Данные хранятся "чистыми" — htmlspecialchars только при выводе в HTML
    $id = $db->insert('applications', [
        'name'       => $name,
        'phone'      => $phone,
        'email'      => $email !== '' ? $email : null,
        'message'    => $message !== '' ? $message : null,
        'source'     => 'website',
        'status'     => 'new',
        'ip_address' => $ip,
        'user_agent' => !empty($_SERVER['HTTP_USER_AGENT'])
                            ? mb_substr($_SERVER['HTTP_USER_AGENT'], 0, 255)
                            : null,
        'created_at' => date('Y-m-d H:i:s'),
    ]);

    // Опционально: уведомления
    // sendNotificationEmail($name, $phone, $email, $message);
    // sendTelegramNotification($name, $phone, $email, $message);

    $response['success'] = true;
    $response['message'] = 'Заявка успешно отправлена! Наш специалист свяжется с вами в ближайшее время.';
    $response['id']      = $id;

} catch (PDOException $e) {
    error_log('[АкваМед] DB error: ' . $e->getMessage());
    $response['message'] = 'Ошибка базы данных. Попробуйте позже.';
    http_response_code(500);
} catch (Exception $e) {
    error_log('[АкваМед] Form error: ' . $e->getMessage());
    $response['message'] = 'Ошибка при обработке заявки. Попробуйте позже.';
    http_response_code(500);
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

// ========== ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ==========

function pluralForm(int $n, string $one, string $two, string $five): string {
    $n  = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) return $five;
    if ($n1 > 1  && $n1 < 5) return $two;
    if ($n1 === 1)            return $one;
    return $five;
}

function sendNotificationEmail(string $name, string $phone, string $email, string $message): void {
    $to      = 'info@kapelnica-med.ru';
    $subject = '=?UTF-8?B?' . base64_encode('Новая заявка — АкваМед') . '?=';
    $body    = "Имя: {$name}\nТелефон: {$phone}\n";
    if ($email)   $body .= "Email: {$email}\n";
    if ($message) $body .= "Сообщение: {$message}\n";
    $body .= 'Дата: ' . date('d.m.Y H:i');

    $headers  = "From: noreply@kapelnica-med.ru\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    mail($to, $subject, $body, $headers);
}

function sendTelegramNotification(string $name, string $phone, string $email, string $message): void {
    $botToken = 'YOUR_BOT_TOKEN'; // заменить
    $chatId   = 'YOUR_CHAT_ID';  // заменить

    $text  = "🔔 <b>Новая заявка — АкваМед</b>\n\n";
    $text .= "👤 <b>Имя:</b> " . htmlspecialchars($name, ENT_QUOTES) . "\n";
    $text .= "📞 <b>Телефон:</b> " . htmlspecialchars($phone, ENT_QUOTES) . "\n";
    if ($email)   $text .= "📧 <b>Email:</b> " . htmlspecialchars($email, ENT_QUOTES) . "\n";
    if ($message) $text .= "💬 <b>Сообщение:</b> " . htmlspecialchars($message, ENT_QUOTES) . "\n";
    $text .= "📅 <b>Дата:</b> " . date('d.m.Y H:i');

    $ch = curl_init("https://api.telegram.org/bot{$botToken}/sendMessage");
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query([
            'chat_id'    => $chatId,
            'text'       => $text,
            'parse_mode' => 'HTML',
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
    ]);
    curl_exec($ch);
    curl_close($ch);
}
