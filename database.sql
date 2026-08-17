-- ============================================================
-- EWU Lost & Found Portal - Database Schema
-- CSE302: Database Management Systems
-- ============================================================

CREATE DATABASE IF NOT EXISTS ewu_lost_found;
USE ewu_lost_found;

-- ---------------------------------
-- Table: users
-- ---------------------------------
DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    ewu_id    VARCHAR(20) NOT NULL UNIQUE,
    name      VARCHAR(50) NOT NULL,
    password  VARCHAR(50) NOT NULL,
    role      ENUM('Student', 'Admin') NOT NULL DEFAULT 'Student'
);

-- ---------------------------------
-- Table: items
-- ---------------------------------
CREATE TABLE items (
    item_id     INT AUTO_INCREMENT PRIMARY KEY,
    item_name   VARCHAR(100) NOT NULL,
    status      ENUM('Lost', 'Found') NOT NULL DEFAULT 'Lost',
    location    VARCHAR(100) NOT NULL,
    reported_by INT,
    CONSTRAINT fk_reported_by
        FOREIGN KEY (reported_by) REFERENCES users(id)
        ON DELETE CASCADE
);

-- ---------------------------------
-- Sample Data
-- ---------------------------------

-- Password for every seeded account is: 1234
INSERT INTO users (ewu_id, name, password, role) VALUES
('2024-1-60-141', 'Faiyaz Hossen',      '1234', 'Student'),
('2024-1-60-250', 'Shariful Islam Akibe','1234', 'Student'),
('2024-1-60-333', 'Fardin Shahriar',    '1234', 'Student'),
('admin-01',      'Jalal Uddin',        '1234', 'Admin');

INSERT INTO items (item_name, status, location, reported_by) VALUES
('Watch',  'Found', 'Canteen',   1),
('BOTTLE', 'Lost',  'wifi zone', 2),
('pen',    'Found', 'eee dept',  3);
