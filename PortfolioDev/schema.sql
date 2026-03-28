CREATE DATABASE IF NOT EXISTS `portfolio_db`;
USE `portfolio_db`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user: admin / admin123
INSERT INTO `users` (`username`, `password`, `email`) VALUES 
('admin', '$2y$12$Tiq0lH/O37OmFWVVSH7QDuWW7pLOcETEEKlDmtPCCFO8J7ljabC7y', 'admin@josephlab.dev')
ON DUPLICATE KEY UPDATE `username`='admin';

CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `subtitle` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `challenge_content` TEXT, 
  `thumbnail_image` VARCHAR(255),
  `detail_image` VARCHAR(255),
  `status` ENUM('Live', 'Staging', 'Draft') DEFAULT 'Draft',
  `technologies` VARCHAR(255),
  `demo_link` VARCHAR(255),
  `repo_link` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `project_objectives` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `project_id` INT NOT NULL,
  `objective` VARCHAR(255) NOT NULL,
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `inquiry_type` VARCHAR(50) NOT NULL,
  `price_range` VARCHAR(50) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `is_read` BOOLEAN DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
