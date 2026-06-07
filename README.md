# АкваМед — Клиника капельниц

## Структура проекта
```
akvamed/
├── index.php              # Главная страница
├── css/
│   └── style.css          # Основные стили
├── js/
│   └── main.js            # JavaScript функционал
├── fonts/                 # Шрифты (добавьте сюда)
├── img/                   # Изображения SVG (добавьте сюда)
├── includes/
│   ├── header.php         # Шапка сайта
│   ├── footer.php         # Подвал сайта
│   └── db.php             # Класс для работы с БД
├── api/
│   └── submit-form.php    # Обработка форм
├── database.sql           # SQL для создания БД
└── .htaccess              # Настройки Apache
```

## Установка

1. **База данных:**
   - Импортируйте `database.sql` в phpMyAdmin
   - Настройте подключение в `includes/db.php`

2. **Изображения:**
   - Скачайте SVG из Figma
   - Поместите в папку `img/`
   - Названия файлов должны совпадать с теми, что указаны в коде:
     - `logo-icon.svg`
     - `doctor-hero.svg`
     - `doctor-consultation.svg`
     - `infusion-bag.svg`
     - `nurse-procedure.svg`
     - `patient-care.svg`
     - `doctor-avatar.svg`
     - `license-1.svg`, `license-2.svg`, `license-3.svg`

3. **Шрифты:**
   - Добавьте шрифты в папку `fonts/`
   - Подключите в CSS если нужно

4. **Настройка:**
   - Укажите реальные данные в `includes/db.php`
   - Настройте email/Telegram уведомления в `api/submit-form.php`

## Технологии
- HTML5 / CSS3
- JavaScript (Vanilla)
- PHP 7.4+
- MySQL / MariaDB
- Apache с mod_rewrite

## Функционал
- Адаптивная вёрстка (mobile-first)
- Аккордеон FAQ
- Слайдер лицензий
- Форма обратной связи с валидацией
- Анимации при скролле
- Мобильное меню
- Подключение к БД через PDO

## Цветовая схема
- Основной: #1B8A4C (зелёный)
- Тёмный: #0F4A2E
- Светлый: #E8F5EE
- Фон: #F8FBF9
