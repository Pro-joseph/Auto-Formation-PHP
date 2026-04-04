-- =============================================
-- Surfo — Taghazout Surf Expo
-- Database creation and seeding script
-- =============================================

CREATE DATABASE IF NOT EXISTS surfo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE surfo;

-- ---- Table: users ----
CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100)  NOT NULL,
    email      VARCHAR(150)  NOT NULL UNIQUE,
    password   VARCHAR(255)  NOT NULL,
    role       ENUM('admin', 'client') NOT NULL DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--- Table: students ----
CREATE TABLE IF NOT EXISTS students (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    country    VARCHAR(100) NOT NULL,
    level      ENUM('Débutant', 'Intermédiaire', 'Avancé') NOT NULL DEFAULT 'Débutant',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ---- Table: lessons ----
CREATE TABLE IF NOT EXISTS lessons (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    title      VARCHAR(150) NOT NULL,
    coach      VARCHAR(100) NOT NULL,
    date_time  DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---- Table: enrollments (table de liaison) ----
CREATE TABLE IF NOT EXISTS enrollments (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    student_id     INT NOT NULL,
    lesson_id      INT NOT NULL,
    payment_status ENUM('Payé', 'En attente') NOT NULL DEFAULT 'En attente',
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (lesson_id)  REFERENCES lessons(id)  ON DELETE CASCADE
);

-- =============================================
-- Seeding — test data
-- =============================================

-- Admin account: admin@surfo.com / password: admin123
INSERT INTO users (name, email, password, role) VALUES
('Gérant', 'admin@surfo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Client accounts (password: password)
INSERT INTO users (name, email, password, role) VALUES
('Lucas Martin',  'lucas@mail.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client'),
('Sofia Gomez',   'sofia@mail.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client'),
('Yuki Tanaka',   'yuki@mail.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client'),
('Omar Benali',   'omar@mail.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client'),
('Emma Dupont',   'emma@mail.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'client');

-- Student profiles
INSERT INTO students (user_id, country, level) VALUES
(2, 'France',  'Débutant'),
(3, 'Espagne', 'Intermédiaire'),
(4, 'Japon',   'Avancé'),
(5, 'Maroc',   'Débutant'),
(6, 'France',  'Intermédiaire');

-- Lessons
INSERT INTO lessons (title, coach, date_time) VALUES
('Session débutants - matin',     'Karim',  '2026-04-05 09:00:00'),
('Perfectionnement vagues',       'Hamza',  '2026-04-06 10:30:00'),
('Initiation planche longue',     'Karim',  '2026-04-07 08:00:00'),
('Session avancés - coucher',     'Hamza',  '2026-04-08 17:00:00'),
('Technique de rame',             'Karim',  '2026-04-09 09:00:00');

-- Enrollments
INSERT INTO enrollments (student_id, lesson_id, payment_status) VALUES
(1, 1, 'Payé'),
(4, 1, 'En attente'),
(2, 2, 'Payé'),
(3, 2, 'Payé'),
(1, 3, 'En attente'),
(5, 3, 'Payé'),
(3, 4, 'Payé'),
(2, 5, 'En attente'),
(4, 5, 'Payé'),
(5, 5, 'En attente');
