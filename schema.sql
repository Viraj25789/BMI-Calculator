CREATE DATABASE IF NOT EXISTS bmi_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE bmi_db;

CREATE TABLE IF NOT EXISTS bmi_records (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    height_cm DECIMAL(8, 2) NOT NULL,
    weight_kg DECIMAL(8, 2) NOT NULL,
    bmi_value DECIMAL(8, 2) NOT NULL,
    status VARCHAR(20) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_bmi_records_created_at (created_at)
) ENGINE=InnoDB;
