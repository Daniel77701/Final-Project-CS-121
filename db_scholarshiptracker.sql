--IN PROGRESS DATABASE
--First Commit

-- Create the database
CREATE DATABASE IF NOT EXISTS db_scholarshiptracker;
USE db_scholarshiptracker;

-- Table for scholarship opportunities
CREATE TABLE scholarships (
    scholarship_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATE,
    requirements TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for applications
CREATE TABLE applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    scholarship_id INT,
    student_name VARCHAR(255) NOT NULL,
    student_email VARCHAR(255) NOT NULL,
    status ENUM('Not Started', 'In Progress', 'Submitted', 'Awarded', 'Rejected') DEFAULT 'Not Started',
    application_date DATE,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (scholarship_id) REFERENCES scholarships(scholarship_id) ON DELETE CASCADE
);

INSERT INTO scholarships (name, description, deadline, requirements) VALUES
('CHED Scholarship', 'A government scholarship for deserving college students.', '2024-11-15', 'GPA above 3.0, Proof of income'),
('OWWA Scholarships', 'Scholarship for dependents of OFWs provided by OWWA.', '2025-01-10', 'OFW parent, GPA above 2.5, Proof of enrollment'),
('DOST Scholarship', 'Science and technology scholarship for students with a strong academic record.', '2024-12-20', 'GPA above 3.5, STEM course enrollment'),
('SM Scholarship', 'A scholarship for financially challenged students with good academic standing.', '2024-11-30', 'GPA above 3.0, Proof of financial need'),
('Aboitiz Scholarship Program', 'Supports students pursuing careers in engineering and business.', '2025-01-25', 'Engineering or business course, GPA above 3.2, Recommendation letter'),
('Megaworld Scholarship', 'A scholarship for students in partner schools demonstrating academic excellence.', '2025-02-15', 'GPA above 3.3, Essay on career goals'),
('Security Bank Scholarship', 'Financial assistance for deserving students in partner schools.', '2024-12-05', 'Partner school enrollment, GPA above 3.0, Financial need proof'),
('CHED Medical Scholarship', 'Scholarship for medical students under the CHED program.', '2024-12-31', 'Medical school enrollment, GPA above 3.2'),
('DOH Pre-Service Scholarship', 'A pre-service scholarship for healthcare students under DOH.', '2024-11-10', 'Healthcare field enrollment, GPA above 3.0, Service agreement'),
('Ayala Foundation Scholarship', 'Scholarship for students with strong academic and leadership skills.', '2025-03-01', 'Leadership experience, GPA above 3.4, Essay on community impact'),
('Hawak Kamay Scholarship', 'Support for students in financial need who show academic promise.', '2024-10-30', 'GPA above 2.8, Proof of financial need'),
('CHED Tulong Dunong Scholarship', 'Financial assistance program for eligible college students.', '2025-01-05', 'GPA above 2.5, Income proof, Recommendation letter'),
('Iskolar ni Juan', 'Scholarship for students in public colleges with good academic standing.', '2025-02-20', 'Public school enrollment, GPA above 3.0'),
('Landbank Scholarship', 'Scholarship for students in agriculture or related fields.', '2024-12-15', 'Agriculture-related course, GPA above 3.0, Service agreement'),
('PHINMA Scholarship', 'Scholarship for students in PHINMA partner schools with financial need.', '2025-01-15', 'PHINMA school enrollment, Financial need, Essay'),
('CHED CoScho Scholarship', 'Co-sponsored scholarship under CHED for deserving students.', '2025-03-10', 'GPA above 3.2, Sponsorship agreement');

INSERT INTO applications (scholarship_id, student_name, student_email, status, application_date) VALUES
(1, 'Jose Cruz', 'jose.cruz@example.com', 'Submitted', '2024-10-15'),
(2, 'Maria Santos', 'maria.santos@example.com', 'In Progress', '2024-10-12'),
(3, 'Mark Bautista', 'mark.bautista@example.com', 'Awarded', '2024-09-25'),
(4, 'Ana Dela Cruz', 'ana.delacruz@example.com', 'Submitted', '2024-10-05'),
(5, 'Carla Ramirez', 'carla.ramirez@example.com', 'Not Started', '2024-10-29'),
(6, 'Miguel Reyes', 'miguel.reyes@example.com', 'Rejected', '2024-09-20'),
(7, 'Isabel Flores', 'isabel.flores@example.com', 'In Progress', '2024-10-20'),
(8, 'Paolo Garcia', 'paolo.garcia@example.com', 'Submitted', '2024-10-22'),
(9, 'Christine Lim', 'christine.lim@example.com', 'Submitted', '2024-10-28'),
(10, 'Juan Dela Cruz', 'juan.delacruz@example.com', 'Awarded', '2024-10-10'),
(11, 'Carlos Santos', 'carlos.santos@example.com', 'In Progress', '2024-10-18'),
(12, 'Julia Roldan', 'julia.roldan@example.com', 'Submitted', '2024-10-19'),
(13, 'Ramon Lopez', 'ramon.lopez@example.com', 'Rejected', '2024-09-22'),
(14, 'Teresa Castillo', 'teresa.castillo@example.com', 'In Progress', '2024-10-24'),
(15, 'Eric Mendoza', 'eric.mendoza@example.com', 'Awarded', '2024-10-26'),
(16, 'Angelica Tan', 'angelica.tan@example.com', 'Submitted', '2024-10-27');
