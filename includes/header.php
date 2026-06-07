<?php
// Подключение к базе данных
require_once 'includes/db.php';

// Получаем данные из БД (при необходимости)
// $services = $db->fetchAll("SELECT * FROM services WHERE active = 1 ORDER BY sort_order");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'АкваМед — Клиника капельниц в Санкт-Петербурге'; ?></title>
    <meta name="description" content="<?php echo $pageDescription ?? 'Клиника капельниц АкваМед в Санкт-Петербурге. Инфузионная терапия, детокс, энергия, красота и поддержка иммунитета.'; ?>">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-main">
            <div class="container">
                <a href="#" class="logo">
                    <div class="logo-icon">
                        <img src = "img/logo.svg">
                    </div>
                    <div class="logo-text">
                        <span class="logo-name">АкваМед</span>
                        <span class="logo-desc">Клиника капельниц</span>
                    </div>
                </a>

                <div class="header-center">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1B8A4C" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <div class="header-info-item">
                        <div class="info-label">Адрес</div>
                        <div class="info-value">Санкт-Петербург, ул. Авиаконструкторов 45к1</div>
                    </div>
                     
                    <div class="header-info-divider"></div>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1B8A4C" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    <div class="header-info-item">
                        <div class="info-label">Поддержка 24/7</div>
                        <div class="info-value">+7 (800) 889-99-99</div>
                    </div>
                </div>

                <div class="header-right">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1B8A4C" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    <div class="header-work-time">
                        <div class="work-label">Время работы</div>
                        <div class="work-value">Круглосуточно</div>
                    </div>
                    <div class="header-socials">
                        <a href="#" class="social-icon" aria-label="Поиск">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        </a>
                        <a href="#" class="social-icon" aria-label="VK">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M15.684 0H8.316C1.592 0 0 1.592 0 8.316v7.368C0 22.408 1.592 24 8.316 24h7.368C22.408 24 24 22.408 24 15.684V8.316C24 1.592 22.408 0 15.684 0zm4.962 17.123h-1.744c-.66 0-.864-.525-2.05-1.714-1.033-1.033-1.49-1.171-1.744-1.171-.356 0-.458.102-.458.593v1.575c0 .424-.135.678-1.253.678-1.846 0-3.896-1.118-5.335-3.202C4.624 10.857 4 8.57 4 8.196c0-.254.102-.491.593-.491h1.744c.44 0 .61.203.78.678.864 2.491 2.303 4.675 2.896 4.675.22 0 .322-.102.322-.66V9.721c-.068-1.186-.695-1.287-.695-1.71 0-.203.17-.407.44-.407h2.744c.373 0 .508.203.508.643v3.473c0 .372.17.508.271.508.22 0 .407-.136.813-.542 1.254-1.406 2.151-3.574 2.151-3.574.119-.254.322-.491.763-.491h1.744c.525 0 .644.27.525.643-.22 1.017-2.354 4.031-2.354 4.031-.186.305-.254.44 0 .78.186.254.796.779 1.203 1.253.745.847 1.32 1.558 1.473 2.049.17.49-.085.744-.576.744z"/></svg>
                        </a>
                        <a href="#" class="social-icon" aria-label="Telegram">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                        </a>
                        <a href="#" class="social-icon" aria-label="WhatsApp">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-nav">
            <div class="container">
                <nav class="main-nav">
                    <a href="#services" class="nav-btn nav-btn-primary">Услуги</a>

                    <!-- Двухуровневое выпадающее меню "О клинике" -->
                    <div class="nav-dropdown-wrap" id="navAboutWrap">
                        <button class="nav-btn-dropdown" id="navAboutBtn" aria-expanded="false" aria-haspopup="true">
                            О клинике
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                        </button>

                        <div class="nav-dropdown" id="navAboutDropdown" role="menu">
                            <ul class="nav-dropdown-list">
                                <li class="nav-dropdown-item has-submenu">
                                    <a href="#about">О нас</a>
                                    <svg class="submenu-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                                    <ul class="nav-submenu">
                                        <li><a href="#doctors">Специалисты</a></li>
                                        <li><a href="#">Отзывы</a></li>
                                        <li><a href="#">Фотогалерея</a></li>
                                        <li><a href="#licenses">Лицензии</a></li>
                                    </ul>
                                </li>
                                <li class="nav-dropdown-item has-submenu">
                                    <a href="#services">Капельницы</a>
                                    <svg class="submenu-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                                    <ul class="nav-submenu">
                                        <li><a href="#services">Капельница на дому</a></li>
                                        <li><a href="#services">Капельница для печени</a></li>
                                        <li><a href="#services">Капельницы для сосудов</a></li>
                                        <li><a href="#services">Капельницы при отравлении алкоголем</a></li>
                                        <li><a href="#services">Капельница для сердца</a></li>
                                        <li><a href="#services">Капельница при стрессе</a></li>
                                    </ul>
                                </li>
                                <li class="nav-dropdown-item"><a href="#prices">Цены</a></li>
                                <li class="nav-dropdown-item"><a href="#articles">Статьи</a></li>
                                <li class="nav-dropdown-item"><a href="#faq">Ответы на вопросы</a></li>
                                <li class="nav-dropdown-item"><a href="#contacts">Контакты</a></li>
                            </ul>
                        </div>
                    </div>

                    <a href="#prices" class="nav-btn">Цены</a>
                    <a href="#doctors" class="nav-btn">Врачи</a>
                    <a href="#contacts" class="nav-btn">Контакты</a>
                    <a href="#articles" class="nav-btn">Статьи</a>
                </nav>
                <div class="header-actions">
                    <a href="#consultation" class="btn btn-outline">Записаться</a>
                    <a href="#" class="btn btn-primary">Капельница на дому</a>
                </div>
            </div>
        </div>
    </header>
