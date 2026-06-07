// ==================== RATE LIMIT (фронтенд, 5 минут) ====================
const RATE_LIMIT_MS = 5 * 60 * 1000;
const RATE_LIMIT_KEY = 'form_last_submit';

function getRateLimitRemaining() {
    const last = parseInt(localStorage.getItem(RATE_LIMIT_KEY) || '0', 10);
    if (!last) return 0;
    const remaining = RATE_LIMIT_MS - (Date.now() - last);
    return remaining > 0 ? remaining : 0;
}

function setRateLimitTimestamp() {
    localStorage.setItem(RATE_LIMIT_KEY, Date.now().toString());
}

function startCooldownTimer(btn, originalText) {
    let interval = setInterval(() => {
        const remaining = getRateLimitRemaining();
        if (remaining <= 0) {
            clearInterval(interval);
            btn.disabled = false;
            btn.textContent = originalText;
            return;
        }
        const mins = Math.floor(remaining / 60000);
        const secs = Math.floor((remaining % 60000) / 1000);
        btn.textContent = `Повторить через ${mins}:${secs.toString().padStart(2, '0')}`;
    }, 1000);
}

function applyRateLimitToBtn(btn) {
    const remaining = getRateLimitRemaining();
    if (remaining <= 0) return;
    const originalText = btn.dataset.originalText || btn.textContent;
    btn.dataset.originalText = originalText;
    btn.disabled = true;
    startCooldownTimer(btn, originalText);
}

function initRateLimit() {
    // Применяем к обеим кнопкам отправки при загрузке страницы
    document.querySelectorAll('#consultationForm [type="submit"], #modalForm [type="submit"]').forEach(btn => {
        btn.dataset.originalText = btn.textContent;
        applyRateLimitToBtn(btn);
    });
}

// ==================== DOM READY ====================
document.addEventListener('DOMContentLoaded', function() {
    initRateLimit();
    initNavDropdown();
    initMobileMenu();
    initFAQ();
    initLicensesSlider();
    initHeroToggle();
    initSmoothScroll();
    initStickyHeader();
    initConsultationForm();
    initModalForm();
    initModalResult();
});

// ==================== NAV DROPDOWN (О клинике) ====================
function initNavDropdown() {
    const wrap = document.getElementById('navAboutWrap');
    const btn  = document.getElementById('navAboutBtn');
    const drop = document.getElementById('navAboutDropdown');
    if (!wrap || !btn || !drop) return;

    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = drop.classList.contains('open');
        closeDropdown();
        if (!isOpen) openDropdown();
    });

    function openDropdown() {
        drop.classList.add('open');
        btn.classList.add('active');
        btn.setAttribute('aria-expanded', 'true');
    }

    function closeDropdown() {
        drop.classList.remove('open');
        btn.classList.remove('active');
        btn.setAttribute('aria-expanded', 'false');
        drop.querySelectorAll('.nav-submenu').forEach(s => s.classList.remove('open'));
        drop.querySelectorAll('.nav-dropdown-item').forEach(i => i.classList.remove('submenu-open'));
    }

    drop.querySelectorAll('.nav-dropdown-item.has-submenu').forEach(function(item) {
        item.addEventListener('mouseenter', function() {
            drop.querySelectorAll('.nav-dropdown-item').forEach(i => {
                i.classList.remove('submenu-open');
                const sub = i.querySelector('.nav-submenu');
                if (sub) sub.classList.remove('open');
            });
            item.classList.add('submenu-open');
            const sub = item.querySelector('.nav-submenu');
            if (sub) sub.classList.add('open');
        });

        item.addEventListener('mouseleave', function(e) {
            if (item.contains(e.relatedTarget)) return;
            item.classList.remove('submenu-open');
            const sub = item.querySelector('.nav-submenu');
            if (sub) sub.classList.remove('open');
        });
    });

    document.addEventListener('click', function(e) {
        if (!wrap.contains(e.target)) closeDropdown();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDropdown();
    });

    drop.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', closeDropdown);
    });
}

// ==================== MOBILE MENU ====================
function initMobileMenu() {
    const header = document.querySelector('.header-nav .container');
    if (!header) return;

    const burger = document.createElement('button');
    burger.className = 'burger-btn';
    burger.innerHTML = '<span></span><span></span><span></span>';
    burger.setAttribute('aria-label', 'Открыть меню');
    header.insertBefore(burger, header.firstChild);

    const nav = document.querySelector('.main-nav');

    burger.addEventListener('click', () => {
        document.body.classList.toggle('menu-open');
        burger.classList.toggle('active');
    });

    nav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            document.body.classList.remove('menu-open');
            burger.classList.remove('active');
        });
    });

    document.addEventListener('click', (e) => {
        if (!header.contains(e.target) && document.body.classList.contains('menu-open')) {
            document.body.classList.remove('menu-open');
            burger.classList.remove('active');
        }
    });
}

// ==================== MODAL FORM (кнопка "Записаться") ====================
function initModalForm() {
    const overlay = document.getElementById('modalFormOverlay');
    const form = document.getElementById('modalForm');
    if (!overlay || !form) return;

    const closeBtn = document.getElementById('modalFormClose');

    // Открытие по кнопке "Записаться"
    document.querySelectorAll('.btn-outline').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Закрытие
    function closeForm() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    closeBtn.addEventListener('click', closeForm);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeForm();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('active')) {
            closeForm();
        }
    });

    // Отправка формы
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            closeForm();

            if (result.success) {
                setRateLimitTimestamp();
                document.querySelectorAll('#consultationForm [type="submit"], #modalForm [type="submit"]').forEach(btn => applyRateLimitToBtn(btn));
                showModalResult('success', result.message || 'Наш специалист свяжется с вами в ближайшее время.');
                form.reset();
            } else {
                let msg = result.message || '';
                if (result.errors && Object.keys(result.errors).length > 0) {
                    msg = Object.values(result.errors).join('<br>');
                }
                showModalResult('error', msg || 'Произошла ошибка при отправке заявки.');
            }
        } catch (err) {
            closeForm();
            showModalResult('error', 'Ошибка соединения. Проверьте интернет и попробуйте снова.');
        }
    });
}

// ==================== MODAL RESULT (успех / ошибка) ====================
let modalResultInitialized = false;

function initModalResult() {
    if (modalResultInitialized) return;
    modalResultInitialized = true;

    const overlay = document.getElementById('modalResultOverlay');
    if (!overlay) return;

    const closeBtn = document.getElementById('modalResultClose');

    function closeResult() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    closeBtn.addEventListener('click', closeResult);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeResult();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('active')) {
            closeResult();
        }
    });
}

function showModalResult(type, message) {
    const overlay = document.getElementById('modalResultOverlay');
    const icon = document.getElementById('modalResultIcon');
    const title = document.getElementById('modalResultTitle');
    const text = document.getElementById('modalResultText');
    const btn = document.getElementById('modalResultBtn');

    if (!overlay) return;

    const isSuccess = type === 'success';

    icon.innerHTML = isSuccess
        ? '<svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>'
        : '<svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>';

    icon.className = 'modal-result-icon' + (isSuccess ? '' : ' error');
    title.textContent = isSuccess ? 'Заявка успешно отправлена!' : 'Произошла какая-то ошибка';
    text.innerHTML = message || '';
    btn.textContent = isSuccess ? 'Хорошо' : 'Повторить попытку';

    // При ошибке — открываем форму снова при клике
    btn.onclick = () => {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        if (!isSuccess) {
            setTimeout(() => {
                const formOverlay = document.getElementById('modalFormOverlay');
                if (formOverlay) {
                    formOverlay.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            }, 300);
        }
    };

    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// ==================== CONSULTATION FORM ====================
function initConsultationForm() {
    const form = document.getElementById('consultationForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        form.querySelectorAll('.form-input').forEach(input => {
            input.style.borderColor = '';
        });

        const formData = new FormData(form);
        const data = Object.fromEntries(formData);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                setRateLimitTimestamp();
                document.querySelectorAll('#consultationForm [type="submit"], #modalForm [type="submit"]').forEach(btn => applyRateLimitToBtn(btn));
                showModalResult('success', result.message || 'Наш специалист свяжется с вами в ближайшее время.');
                form.reset();
            } else {
                let errorMsg = result.message || '';
                if (result.errors && Object.keys(result.errors).length > 0) {
                    const errorList = Object.values(result.errors).join('<br>');
                    errorMsg = errorList;
                    for (const [field, msg] of Object.entries(result.errors)) {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) input.style.borderColor = '#e74c3c';
                    }
                }
                showModalResult('error', errorMsg || 'Произошла ошибка при отправке заявки.');
            }

        } catch (err) {
            showModalResult('error', 'Ошибка соединения. Проверьте интернет и попробуйте снова.');
        }
    });
}

// ==================== FAQ ACCORDION ====================
function initFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');

        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            faqItems.forEach(i => {
                i.classList.remove('active');
                const icon = i.querySelector('.faq-toggle-icon');
                if (icon) icon.textContent = '+';
            });

            if (!isActive) {
                item.classList.add('active');
                const icon = item.querySelector('.faq-toggle-icon');
                if (icon) icon.textContent = String.fromCharCode(8722);
            }
        });
    });
}

// ==================== LICENSES SLIDER ====================
function initLicensesSlider() {
    const track = document.querySelector('.licenses-right');
    const prevBtn = document.querySelector('.licenses-nav-btn.prev');
    const nextBtn = document.querySelector('.licenses-nav-btn.next');
    const cards = document.querySelectorAll('.license-card');

    if (!track || !cards.length) return;

    let currentIndex = 0;
    const totalCards = cards.length;
    const cardsPerView = window.innerWidth > 768 ? 3 : 1;
    const maxIndex = Math.max(0, totalCards - cardsPerView);

    function updateSlider() {
        if (window.innerWidth > 768) return;
        const cardWidth = cards[0].offsetWidth + 20;
        track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
        track.style.transition = 'transform 0.5s ease';
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            currentIndex = Math.max(0, currentIndex - 1);
            updateSlider();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            currentIndex = Math.min(maxIndex, currentIndex + 1);
            updateSlider();
        });
    }

    let startX = 0;
    let isDragging = false;

    track.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
    });

    track.addEventListener('touchend', (e) => {
        if (!isDragging) return;
        const endX = e.changedTouches[0].clientX;
        const diff = startX - endX;

        if (Math.abs(diff) > 50) {
            if (diff > 0) {
                currentIndex = Math.min(maxIndex, currentIndex + 1);
            } else {
                currentIndex = Math.max(0, currentIndex - 1);
            }
            updateSlider();
        }
        isDragging = false;
    });

    window.addEventListener('resize', () => {
        currentIndex = 0;
        track.style.transform = '';
    });
}

// ==================== HERO TOGGLE ====================
function initHeroToggle() {
    const toggleBtns = document.querySelectorAll('.toggle-btn');

    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            toggleBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

// ==================== SMOOTH SCROLL ====================
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;

            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ==================== STICKY HEADER ====================
function initStickyHeader() {
    const header = document.querySelector('.header');
    if (!header) return;

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 100) {
            header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.1)';
        } else {
            header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.05)';
        }
    });
}

// ==================== NOTIFICATIONS ====================
function showNotification(message, type) {
    type = type || 'info';
    const notification = document.createElement('div');
    notification.className = 'notification notification-' + type;
    notification.textContent = message;

    const colors = {
        success: '#1B8A4C',
        error: '#e74c3c',
        info: '#3498db',
        warning: '#f39c12'
    };

    notification.style.cssText = 'position:fixed;top:20px;right:20px;padding:16px 24px;border-radius:12px;color:white;font-weight:500;z-index:10000;animation:slideIn 0.3s ease;max-width:400px;box-shadow:0 4px 20px rgba(0,0,0,0.15);';
    notification.style.background = colors[type] || colors.info;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease forwards';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// ==================== CSS ANIMATIONS ====================
const animStyles = document.createElement('style');
animStyles.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(animStyles);
