-- Scholarships table
CREATE TABLE scholarships (
    id INT PRIMARY KEY AUTO_INCREMENT,
    scholarship_type VARCHAR(100) NOT NULL,
    scholarship_grade VARCHAR(50) NOT NULL,
    last_submission_date DATE NOT NULL,
    published_date DATE NOT NULL,
    year_scholarship VARCHAR(20),
    category VARCHAR(50),
    criteria TEXT,
    documents_required TEXT,
    description TEXT,
    amount DECIMAL(10,2)
);

-- Applications table
CREATE TABLE applications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    scholarship_id INT,
    photo_path VARCHAR(255),
    full_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender VARCHAR(20) NOT NULL,
    mobile_number VARCHAR(20),
    application_number VARCHAR(20) UNIQUE,
    email VARCHAR(100) NOT NULL,
    sr_code INT UNIQUE NOT NULL(20),
    year_level VARCHAR(20),
    documents_path TEXT,
    status VARCHAR(20) DEFAULT 'PENDING',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (scholarship_id) REFERENCES scholarships(id)
);

-- Insert sample scholarship data
INSERT INTO scholarships (
    scholarship_type,
    scholarship_grade,
    last_submission_date,
    published_date,
    year_scholarship,
    category,
    criteria,
    documents_required,
    description,
    amount
) VALUES 
(
    'Academic Excellence',
    '1st Year',
    '2024-11-15',
    '2024-10-01',
    '2024-2025',
    'Merit-based',
    'Applicants must have an overall average of 90% or above in their most recent academic year or term.',
    'Birth Certificate, Report Card, Enrollment Form',
    'Rewards outstanding students who consistently achieve high grades',
    3000
),
(
    'Financial Assistance',
    'All Year Levels',
    '2024-11-20',
    '2024-10-05',
    '2024-2025',
    'Need-based',
    'Must demonstrate financial need',
    'Income Certificate, Birth Certificate, Enrollment Form',
    'Provides support to students with financial constraints',
    2500
);