-- Create database
CREATE DATABASE scholarship_tracker;
USE scholarship_tracker;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mobile_number VARCHAR(20),
    sr_code INT UNIQUE NOT NULL(20),
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_type ENUM('student', 'admin') DEFAULT 'student',
    profile_photo VARCHAR(255)
);

-- Scholarships table
CREATE TABLE scholarships (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(100) NOT NULL,
    grade VARCHAR(50),
    year_level VARCHAR(50),
    description TEXT,
    criteria TEXT,
    amount DECIMAL(10,2),
    deadline DATE,
    published_date DATE,
    documents_required TEXT
);

-- Applications table
CREATE TABLE applications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    scholarship_id INT,
    application_number VARCHAR(20) UNIQUE,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    apply_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    documents_submitted TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (scholarship_id) REFERENCES scholarships(id)
);

-- Exam Results table
CREATE TABLE exam_results (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    result TEXT,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Feedback table
CREATE TABLE feedback (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    message TEXT,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);