-- Application History Table
CREATE TABLE application_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    application_no VARCHAR(20) UNIQUE NOT NULL,
    scholarship_type VARCHAR(100) NOT NULL,
    applicant_name VARCHAR(100) NOT NULL,
    mobile_number VARCHAR(20) NOT NULL,
    apply_date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    photo_path VARCHAR(255),
    date_of_birth DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL,
    sr_code VARCHAR(20) NOT NULL,
    year_level VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO application_history (
    application_no,
    scholarship_type,
    applicant_name,
    mobile_number,
    apply_date,
    status,
    photo_path,
    date_of_birth,
    gender,
    email,
    sr_code,
    year_level
) VALUES (
    '9876',
    'Academic Excellence',
    'John Doe',
    '09778455634',
    '2024-10-03',
    'Approved',
    '/uploads/profile.jpg',
    '2000-01-01',
    'Male',
    '22-36298@g.batstate-u.edu.ph',
    '22-36298',
    '1st Year'
);