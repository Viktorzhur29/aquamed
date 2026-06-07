-- ============================================================
--  АкваМед — База данных для заявок с сайта
--  Создать БД: akvamed_db (кодировка utf8mb4)
-- ============================================================

CREATE DATABASE IF NOT EXISTS akvamed_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE akvamed_db;

-- ------------------------------------------------------------
--  Таблица заявок с форм сайта
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS applications (
    id            INT UNSIGNED    NOT NULL AUTO_INCREMENT,

    -- Данные клиента
    name          VARCHAR(100)    NOT NULL                COMMENT 'Имя клиента',
    phone         VARCHAR(30)     NOT NULL                COMMENT 'Телефон',
    email         VARCHAR(100)    DEFAULT NULL            COMMENT 'Email (необязательно)',
    message       TEXT            DEFAULT NULL            COMMENT 'Сообщение / вопрос',

    -- Метаданные
    source        VARCHAR(50)     NOT NULL DEFAULT 'website'   COMMENT 'Источник: website / modal / callback',
    status        ENUM(
                      'new',          -- новая, не обработана
                      'in_progress',  -- в работе
                      'done',         -- обработана
                      'cancelled'     -- отменена / спам
                  )               NOT NULL DEFAULT 'new'  COMMENT 'Статус заявки',

    ip_address    VARCHAR(45)     DEFAULT NULL            COMMENT 'IP клиента (IPv4/IPv6)',
    user_agent    VARCHAR(255)    DEFAULT NULL            COMMENT 'User-Agent браузера',

    created_at    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT 'Дата создания',
    updated_at    DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP
                                  ON UPDATE CURRENT_TIMESTAMP        COMMENT 'Дата изменения',
    processed_at  DATETIME        DEFAULT NULL            COMMENT 'Дата обработки менеджером',
    processed_by  VARCHAR(100)    DEFAULT NULL            COMMENT 'Кто обработал',
    notes         TEXT            DEFAULT NULL            COMMENT 'Внутренние заметки менеджера',

    PRIMARY KEY (id),
    INDEX idx_status      (status),
    INDEX idx_phone       (phone),
    INDEX idx_created_at  (created_at),
    INDEX idx_source      (source)

) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Заявки с форм сайта АкваМед';


-- ------------------------------------------------------------
--  Примеры запросов для работы с таблицей
-- ------------------------------------------------------------

-- Все новые заявки (для менеджера)
-- SELECT id, name, phone, email, source, created_at
-- FROM applications
-- WHERE status = 'new'
-- ORDER BY created_at DESC;

-- Заявки за сегодня
-- SELECT * FROM applications
-- WHERE DATE(created_at) = CURDATE()
-- ORDER BY created_at DESC;

-- Пометить заявку как обработанную
-- UPDATE applications
-- SET status = 'done',
--     processed_at = NOW(),
--     processed_by = 'Менеджер Иван'
-- WHERE id = 1;

-- Статистика по источникам за месяц
-- SELECT source, status, COUNT(*) AS cnt
-- FROM applications
-- WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
-- GROUP BY source, status
-- ORDER BY source, cnt DESC;
