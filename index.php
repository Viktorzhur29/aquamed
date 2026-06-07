<?php
$pageTitle = 'АкваМед — Клиника капельниц в Санкт-Петербурге';
$pageDescription = 'Клиника капельниц АкваМед в Санкт-Петербурге. Инфузионная терапия, детокс, энергия, красота и поддержка иммунитета. Работаем круглосуточно.';

// Подключение к БД
require_once 'includes/db.php';

// Получаем FAQ из БД
$faqItems = [];
try {
    $db = Database::getInstance();
    $faqItems = $db->fetchAll("SELECT * FROM faq WHERE active = 1 ORDER BY sort_order");
} catch (Exception $e) {
    $faqItems = [];
}

require_once 'includes/header.php';
?>

    <!-- Hero Section -->
    <section class="hero" id="services">
        <div class="container">
            <div class="hero-content">
                <h1>Клиника капельниц <span>АкваМед</span><br>в Санкт-Петербурге</h1>
                <p class="hero-subtitle">Инфузионные программы под контролем врачей: детокс, энергия, красота и поддержка иммунитета</p>
                <div class="hero-toggle">
                    <button class="toggle-btn active">В клинике</button>
                    <button class="toggle-btn">На дому</button>
                </div>
                <div class="hero-cards">
                    <div class="service-card">
                        <div class="service-card-header">
                            <span class="service-card-title">Капельница Детокс</span>
                            <div class="service-card-icon"><img src="img/reindrop_1.svg" alt=""></div>
                        </div>
                        <p class="service-card-desc">Очищение организма после алкоголя и токсинов</p>
                        <div class="service-card-price">Цена: от 5 000 ₽</div>
                        <button class="service-card-btn">Подробнее</button>
                    </div>
                    <div class="service-card">
                        <div class="service-card-header">
                            <span class="service-card-title">Капельница Энергия</span>
                            <div class="service-card-icon"><img src="img/reindrop_2.svg" alt=""></div>
                        </div>
                        <p class="service-card-desc">Быстрое восстановление сил и тонуса</p>
                        <div class="service-card-price">Цена: от 5 000 ₽</div>
                        <button class="service-card-btn">Подробнее</button>
                    </div>
                    <div class="service-card">
                        <div class="service-card-header">
                            <span class="service-card-title">Капельница Золушка</span>
                            <div class="service-card-icon"><img src="img/reindrop_3.svg" alt=""></div>
                        </div>
                        <p class="service-card-desc">Омоложение кожи, сияние изнутри</p>
                        <div class="service-card-price">Цена: от 5 900 ₽</div>
                        <button class="service-card-btn">Подробнее</button>
                    </div>
                </div>
                <div class="hero-actions">
                    <a href="#consultation" class="btn btn-primary">Подобрать капельницу</a>
                    <a href="#consultation" class="btn btn-light">Бесплатная консультация</a>
                </div>
            </div>
            <div class="hero-image">
                <div class="hero-image-bg"></div>
                <img src="img/doctor.svg" alt="Врач">
            </div>
        </div>
        <div class="hero-waves">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 120 600" preserveAspectRatio="none">
                <path d="M20 0 C40 50, 0 100, 20 150 C40 200, 0 250, 20 300 C40 350, 0 400, 20 450 C40 500, 0 550, 20 600" fill="none" stroke="rgba(27,138,76,0.2)" stroke-width="1.5"/>
                <path d="M40 0 C20 50, 60 100, 40 150 C20 200, 60 250, 40 300 C20 350, 60 400, 40 450 C20 500, 60 550, 40 600" fill="none" stroke="rgba(27,138,76,0.2)" stroke-width="1.5"/>
                <path d="M75 0 C95 50, 55 100, 75 150 C95 200, 55 250, 75 300 C95 350, 55 400, 75 450 C95 500, 55 550, 75 600" fill="none" stroke="rgba(27,138,76,0.2)" stroke-width="1.5"/>
                <path d="M95 0 C75 50, 115 100, 95 150 C75 200, 115 250, 95 300 C75 350, 115 400, 95 450 C75 500, 115 550, 95 600" fill="none" stroke="rgba(27,138,76,0.2)" stroke-width="1.5"/>
            </svg>
        </div>
    </section>

    <!-- Benefits -->

    <!-- Benefits -->
    <section class="benefits" id="about">
        <div class="bg-circle bg-circle-1"></div>
        <div class="bg-circle bg-circle-2"></div>
        <div class="bg-circle bg-circle-3"></div>
        <div class="bg-circle bg-circle-4"></div>
        <div class="bg-circle bg-circle-5"></div>
        <div class="bg-circle bg-circle-6"></div>
        <div class="container">
            <h2 class="benefits-title">Что даёт инфузионная терапия?</h2>
            <div class="benefits-layout">
                <div class="benefits-left">
                    <div class="benefit-card benefit-card-top">
                        <div class="benefit-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#1B8A4C" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        </div>
                        <p>Эффект уже после<br>первой процедуры</p>
                    </div>
                    <div class="benefit-card benefit-card-bottom">
                        <div class="benefit-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#1B8A4C" stroke-width="2"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                        </div>
                        <p>100% усвоение — витамины<br>и препараты минуют ЖКТ</p>
                    </div>
                </div>
                <div class="benefits-center-img">
                    <img src="img/hz.svg" alt="Капельница">
                </div>
                <div class="benefits-right">
                    <div class="benefit-card benefit-card-top">
                        <div class="benefit-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#1B8A4C" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </div>
                        <p>5 капельниц = 3 месяца<br>приёма витаминов</p>
                    </div>
                    <div class="benefit-card benefit-card-bottom">
                        <div class="benefit-card-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#1B8A4C" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </div>
                        <p>Без нагрузки на желудок<br>и печень</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Consultation -->
    <section class="consultation" id="consultation">
        <div class="container">
            <div class="consultation-content">
                <h2>Не знаете какая капельница<br>или процедура вам подойдёт?</h2>
                <p>Оставьте заявку, наш специалист перезвонит вам и бесплатно проконсультирует вас</p>
                <form class="consultation-form" id="consultationForm" action="api/submit-form.php" method="POST">
                    <div class="form-row">
                        <input type="text" name="name" class="form-input" placeholder="Ваше имя *" required>
                        <input type="tel" name="phone" class="form-input" placeholder="Ваш телефон *" required>
                    </div>
                    <input type="email" name="email" class="form-input" placeholder="Email (необязательно)">
                    <textarea name="message" class="form-input form-textarea" placeholder="Опишите вашу проблему или вопрос"></textarea>
                    <div class="form-submit">
                        <button type="submit" class="btn btn-white">Отправить заявку</button>
                        <span class="form-policy">Нажимая на кнопку, вы соглашаетесь с политикой конфиденциальности</span>
                    </div>
                </form>
            </div>
            <div class="consultation-image">
                <img src="img/doctor_2.svg" alt="Консультация">
            </div>
        </div>
        <!-- Волнистые линии справа -->
        <div class="consultation-waves">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 120 600" preserveAspectRatio="none">
                <path d="M20 0 C40 50, 0 100, 20 150 C40 200, 0 250, 20 300 C40 350, 0 400, 20 450 C40 500, 0 550, 20 600" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
                <path d="M40 0 C20 50, 60 100, 40 150 C20 200, 60 250, 40 300 C20 350, 60 400, 40 450 C20 500, 60 550, 40 600" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
                <path d="M75 0 C95 50, 55 100, 75 150 C95 200, 55 250, 75 300 C95 350, 55 400, 75 450 C95 500, 55 550, 75 600" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
                <path d="M95 0 C75 50, 115 100, 95 150 C75 200, 115 250, 95 300 C75 350, 115 400, 95 450 C75 500, 115 550, 95 600" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
            </svg>
        </div>
    </section>

    <!-- Text Blocks -->
    <section class="text-blocks" id="articles">
        <div class="text-block">
            <div class="container">
                <div class="text-block-left">
                    <h2>Текстовый блок</h2>
                    <p>Приятно, граждане, наблюдать, как многие известные личности своевременно верифицированы. Господа, высококачественный прототип будущего проекта играет определяющее значение для вывода текущих активов. Наше дело не так однозначно, как может показаться: постоянное информационно-пропагандистское обеспечение нашей деятельности способствует повышению качества экспериментов, поражающих по своей масштабности и грандиозности. Кстати, реплицированные с зарубежных источников, современные исследования формируют глобальную экономическую сеть и при этом — объявлены нарушающими общечеловеческие нормы этики и морали.</p>
                    <p>В целом, конечно, синтетическое тестирование предопределяет высокую востребованность экономической целесообразности принимаемых решений. Наше дело не так однозначно, как может показаться: убеждённость некоторых оппонентов говорит о возможностях модели развития. Однозначно, предприниматели в сети интернет своевременно верифицированы.</p>
                    <p>Наше дело не так однозначно, как может показаться:</p>
                    <ul class="text-block-list">
                        <li>информационно-пропагандистское обеспечение нашей деятельности</li>
                        <li>предприниматели в сети интернет</li>
                        <li>реплицированные с зарубежных источников, современные исследования</li>
                        <li>убеждённость некоторых оппонентов говорит о возможностях модели развития</li>
                        <li>определяющее значение для вывода текущих активов</li>
                    </ul>
                    <div class="highlight-box">
                        <div class="highlight-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg></div>
                        <p>Ясность нашей позиции очевидна: курс на социально-ориентированный национальный проект однозначно фиксирует необходимость дальнейших направлений развития. В своём стремлении повысить качество жизни, они забывают, что социально-экономическое развитие в значительной степени обусловливает важность экономической целесообразности принимаемых решений.</p>
                    </div>
                    <p>Приятно, граждане, наблюдать, как многие известные личности своевременно верифицированы. Господа, высококачественный прототип будущего проекта играет определяющее значение для вывода текущих активов. Наше дело не так однозначно, как может показаться: постоянное информационно-пропагандистское обеспечение нашей деятельности способствует повышению качества экспериментов, поражающих по своей масштабности и грандиозности.</p>
                    <p>Разнообразный и богатый опыт говорит нам, что курс на социально-ориентированный национальный проект:</p>
                    <ol class="text-block-numbered">
                        <li><span>01</span> Информационно-пропагандистское обеспечение нашей деятельности</li>
                        <li><span>02</span> Предприниматели в сети интернет</li>
                        <li><span>03</span> Реплицированные с зарубежных источников, современные исследования</li>
                        <li><span>04</span> Убеждённость некоторых оппонентов говорит о возможностях модели развития</li>
                        <li><span>05</span> Определяющее значение для вывода текущих активов некоторых оппонентов говорит о возможностях модели развития</li>
                    </ol>
                    <p>В целом, конечно, синтетическое тестирование предопределяет высокую востребованность экономической целесообразности принимаемых решений. Наше дело не так однозначно, как может показаться: убеждённость некоторых оппонентов говорит о возможностях модели развития. Однозначно, предприниматели в сети интернет своевременно верифицированы.</p>
                </div>
                <div class="text-block-right">
                    <img src="img/text_1.svg" alt="Процедура">
                </div>
            </div>
        </div>
        <div class="text-block">
            <div class="container">
                <div class="text-block-left">
                    <h2>Текстовый блок Н3</h2>
                    <p>Приятно, граждане, наблюдать, как многие известные личности своевременно верифицированы. Господа, высококачественный прототип будущего проекта играет определяющее значение для вывода текущих активов. Наше дело не так однозначно, как может показаться: постоянное информационно-пропагандистское обеспечение нашей деятельности способствует повышению качества экспериментов, поражающих по своей масштабности и грандиозности. Кстати, реплицированные с зарубежных источников, современные исследования формируют глобальную экономическую сеть и при этом — объявлены нарушающими общечеловеческие нормы этики и морали.</p>
                    <p>В целом, конечно, синтетическое тестирование предопределяет высокую востребованность экономической целесообразности принимаемых решений. Наше дело не так однозначно, как может показаться: убеждённость некоторых оппонентов говорит о возможностях модели развития. Однозначно, предприниматели в сети интернет своевременно верифицированы.</p>
                    <div class="highlight-box">
                        <div class="highlight-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg></div>
                        <p>Ясность нашей позиции очевидна: курс на социально-ориентированный национальный проект однозначно фиксирует необходимость дальнейших направлений развития. В своём стремлении повысить качество жизни, они забывают, что социально-экономическое развитие в значительной степени обусловливает важность экономической целесообразности принимаемых решений.</p>
                    </div>
                    <div class="doctor-card-inline">
                        <img src="img/doctor.svg" alt="Врач" class="doctor-card-avatar">
                        <div class="doctor-card-info">
                            <h4>Константинопольский Константин Константинович</h4>
                            <p>Главный врач клиники, психиатр-нарколог</p>
                            <span class="experience">Опыт работы: 15 лет</span>
                        </div>
                    </div>
                    <p>В целом, конечно, синтетическое тестирование предопределяет высокую востребованность экономической целесообразности принимаемых решений. Наше дело не так однозначно, как может показаться: убеждённость некоторых оппонентов говорит о возможностях модели развития. Однозначно, предприниматели в сети интернет своевременно верифицированы.</p>
                </div>
                <div class="text-block-right">
                    <img src="img/text_2.svg" alt="Уход">
                </div>
            </div>
        </div>
    </section>

    <!-- Licenses -->
    <section class="licenses" id="licenses">
        <div class="container">
            <div class="licenses-layout">
                <div class="licenses-left">
                    <h2 class="licenses-title">Лицензии клиники<br>АкваМед</h2>
                    <p class="licenses-text">Клиника работает на основании медицинской лицензии и всех необходимых разрешений. Работаем с пациентами на основе заключённого договора о предоставлении медицинских услуг — прозрачно, безопасно и с защитой вашего здоровья.</p>
                    <p class="licenses-text">Мы используем только сертифицированные препараты и соблюдаем стандарты Министерства здравоохранения РФ.</p>
                    <p class="licenses-text">Медицинская лицензия ООО «Кристалл» Л041-01148-78/00347913</p>
                    <div class="licenses-nav">
                        <button class="licenses-nav-btn prev" aria-label="Предыдущая">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        </button>
                        <button class="licenses-nav-btn next" aria-label="Следующая">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
                <div class="licenses-right">
                    <div class="license-card">
                        <div class="license-img-wrapper">
                            <img src="img/License.svg" alt="Лицензия 1">
                        </div>
                        <p class="license-desc">Приятно, граждане, наблюдать, как многие известные личности своевременно верифицированы</p>
                    </div>
                    <div class="license-card">
                        <div class="license-img-wrapper">
                            <img src="img/License.svg" alt="Лицензия 2">
                        </div>
                        <p class="license-desc">Приятно, граждане, наблюдать, как многие известные личности своевременно верифицированы</p>
                    </div>
                    <div class="license-card">
                        <div class="license-img-wrapper">
                            <img src="img/License.svg" alt="Лицензия 3">
                        </div>
                        <p class="license-desc">Приятно, граждане, наблюдать, как многие известные личности своевременно верифицированы</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq" id="faq">
        <div class="container">
            <h2 class="faq-title">Отвечаем на ваши вопросы</h2>
            <div class="faq-list">
                <?php if (!empty($faqItems)): ?>
                    <?php foreach ($faqItems as $index => $faq): ?>
                        <div class="faq-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <button class="faq-question">
                                <span><?php echo htmlspecialchars($faq['question']); ?></span>
                                <span class="faq-toggle-icon"><?php echo $index === 0 ? '−' : '+'; ?></span>
                            </button>
                            <div class="faq-answer">
                                <p><?php echo htmlspecialchars($faq['answer']); ?></p>
                                <?php if ($index === 0): ?>
                                    <div class="faq-doctor">
                                        <img src="img/doctor.svg" alt="Врач">
                                        <div class="faq-doctor-info">
                                            <h4>Константинопольский Константин Константинович</h4>
                                            <p>Главный врач клиники, психиатр-нарколог</p>
                                            <span class="experience">Опыт работы: 15 лет</span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback статичный FAQ если БД недоступна -->
                    <div class="faq-item active">
                        <button class="faq-question">
                            <span>Существуют ли в клинике пакетные предложения или скидки?</span>
                            <span class="faq-toggle-icon">−</span>
                        </button>
                        <div class="faq-answer">
                            <p>Клиника работает на основании медицинской лицензии и всех необходимых разрешений. Работаем с пациентами на основе заключения договора о предоставлении медицинских услуг — прозрачно, безопасно и с защитой вашего здоровья.</p>
                            <div class="faq-doctor">
                                <img src="img/doctor.svg" alt="Врач">
                                <div class="faq-doctor-info">
                                    <h4>Константинопольский Константин Константинович</h4>
                                    <p>Главный врач клиники, психиатр-нарколог</p>
                                    <span class="experience">Опыт работы: 15 лет</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Клиника работает на основании медицинской лицензии?</span>
                            <span class="faq-toggle-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Абсолютно верно. Наша лицензия выдана Министерством здравоохранения и соответствует всем современным стандартам.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Modal Form -->
    <div class="modal-form-overlay" id="modalFormOverlay">
        <div class="modal-form">
            <button class="modal-form-close" id="modalFormClose" aria-label="Close">&times;</button>
            <h3 class="modal-form-title">Не знаете какая капельница или процедура вам подойдёт?</h3>
            <p class="modal-form-subtitle">Оставьте заявку, наш специалист перезвонит вам и бесплатно проконсультирует вас</p>
            <form class="modal-form-form" id="modalForm" action="api/submit-form.php" method="POST">
                <div class="modal-form-row">
                    <input type="text" name="name" class="modal-form-input" placeholder="Ваше имя" required>
                    <input type="text" name="phone" class="modal-form-input" placeholder="Телефон / Email" required>
                </div>
                <button type="submit" class="modal-form-btn">Отправить заявку</button>
                <p class="modal-form-policy">Нажимая на кнопку, вы соглашаетесь с политикой конфиденциальности</p>
            </form>
        </div>
    </div>

    <!-- Modal Result -->
    <div class="modal-result-overlay" id="modalResultOverlay">
        <div class="modal-result">
            <button class="modal-result-close" id="modalResultClose" aria-label="Close">&times;</button>
            <div class="modal-result-icon" id="modalResultIcon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
            </div>
            <h3 id="modalResultTitle">Заявка успешно отправлена!</h3>
            <p id="modalResultText">Наш специалист свяжется с вами в ближайшее время.</p>
            <button class="modal-result-btn" id="modalResultBtn">Хорошо</button>
        </div>
    </div>

<?php require_once 'includes/footer.php'; ?>