-- Create the database
CREATE DATABASE IF NOT EXISTS db_scholarshiptracker CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE db_scholarshiptracker;

-- Table for Scholarships
CREATE TABLE IF NOT EXISTS `scholarships` (
    scholarship_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATE,
    requirements TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Table for Students
CREATE TABLE IF NOT EXISTS `students` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    sr_code VARCHAR(100) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS featured_scholars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    course VARCHAR(255) NOT NULL,
    year_graduated YEAR NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(50) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Table for Applications
CREATE TABLE IF NOT EXISTS `applications` (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    scholarship_id INT,
    student_id INT,
    status ENUM('Not Started', 'In Progress', 'Submitted', 'Awarded', 'Rejected') DEFAULT 'Not Started',
    application_date DATE,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (scholarship_id) REFERENCES scholarships(scholarship_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Table for Scholarship Requirements
CREATE TABLE IF NOT EXISTS `scholarship_requirements` (
    requirement_id INT AUTO_INCREMENT PRIMARY KEY,
    scholarship_id INT,
    requirement_text TEXT NOT NULL,
    FOREIGN KEY (scholarship_id) REFERENCES scholarships(scholarship_id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Table for Application Status History
CREATE TABLE IF NOT EXISTS `application_status_history` (
    history_id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT,
    status ENUM('Not Started', 'In Progress', 'Submitted', 'Awarded', 'Rejected') NOT NULL,
    status_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES applications(application_id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Table for Reviewers
CREATE TABLE IF NOT EXISTS `reviewers` (
    reviewer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Table for Application Reviews
CREATE TABLE IF NOT EXISTS `application_reviews` (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT,
    reviewer_id INT,
    score INT,
    comments TEXT,
    review_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES applications(application_id) ON DELETE CASCADE,
    FOREIGN KEY (reviewer_id) REFERENCES reviewers(reviewer_id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Insert Data into Scholarships Table
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

-- Insert Data into Students Table
-- Insert Data into Students Table with Unique SR Codes (Including 23-XXXX for 6 students)
INSERT INTO students (name, email, sr_code, mobile_number, password) VALUES
('Jose Cruz', 'jose.cruz@gmail.com', '21-20930', '09123456789', 'password123'),
('Maria Santos', 'maria.santos@gmail.com', '21-89012', '09123456780', 'password123'),
('Mark Bautista', 'mark.bautista@gmail.com', '21-23456', '09123456781', 'password123'),
('Ana Dela Cruz', 'ana.delacruz@gmail.com', '21-34567', '09123456782', 'password123'),
('Carla Ramirez', 'carla.ramirez@gmail.com', '22-45678', '09123456783', 'password123'),
('Miguel Reyes', 'miguel.reyes@gmail.com', '21-56789', '09123456784', 'password123'),
('Isabel Flores', 'isabel.flores@gmail.com', '21-67890', '09123456785', 'password123'),
('Paolo Garcia', 'paolo.garcia@gmail.com', '21-78901', '09123456786', 'password123'),
('Christine Lim', 'christine.lim@gmail.com', '21-89012', '09123456787', 'password123'),
('Juan Dela Cruz', 'juan.delacruz@gmail.com', '21-90123', '09123456788', 'password123'),
('Carlos Santos', 'carlos.santos@gmail.com', '21-01234', '09123456789', 'password123'),
('Julia Roldan', 'julia.roldan@gmail.com', '22-12345', '09123456790', 'password123'),
('Ramon Lopez', 'ramon.lopez@gmail.com', '21-23456', '09123456791', 'password123'),
('Teresa Castillo', 'teresa.castillo@gmail.com', '21-34567', '09123456792', 'password123'),
('Eric Mendoza', 'eric.mendoza@gmail.com', '21-45678', '09123456793', 'password123'),
('Angelica Tan', 'angelica.tan@gmail.com', '21-56789', '09123456794', 'password123'),
('Jerome Alcantara', 'jerome.alcantara@gmail.com', '21-67890', '09123456795', 'password123'),
('Lyka Mendoza', 'lyka.mendoza@gmail.com', '21-78901', '09123456796', 'password123'),
('Carlos Aquino', 'carlos.aquino@gmail.com', '21-89012', '09123456797', 'password123'),
('Karla Garcia', 'karla.garcia@gmail.com', '22-90123', '09123456798', 'password123'),
('Miguel Fernandez', 'miguel.fernandez@gmail.com', '21-01234', '09123456799', 'password123'),
('Roselle Bautista', 'roselle.bautista@gmail.com', '21-12345', '09123456800', 'password123'),
('Patrick Reyes', 'patrick.reyes@gmail.com', '21-23456', '09123456801', 'password123'),
('Angela Marquez', 'angela.marquez@gmail.com', '22-34567', '09123456802', 'password123'),
('Emilio Navarro', 'emilio.navarro@gmail.com', '21-45678', '09123456803', 'password123'),
('Diana Santos', 'diana.santos@gmail.com', '21-56789', '09123456804', 'password123'),
('Leah Cortez', 'leah.cortez@gmail.com', '21-67890', '09123456805', 'password123'),
('Felix Cruz', 'felix.cruz@gmail.com', '21-78901', '09123456806', 'password123'),
('Sandra Diaz', 'sandra.diaz@gmail.com', '22-89012', '09123456807', 'password123'),
('Raymond Mercado', 'raymond.mercado@gmail.com', '21-90123', '09123456808', 'password123'),
('Carmen Ortiz', 'carmen.ortiz@gmail.com', '21-01234', '09123456809', 'password123'),
('Sophia Cruz', 'sophia.cruz@gmail.com', '23-09231', '09123456810', 'password123'),
('Liam Garcia', 'liam.garcia@gmail.com', '23-09232', '09123456811', 'password123'),
('Oliver Reyes', 'oliver.reyes@gmail.com', '23-09233', '09123456812', 'password123'),
('Emma Santos', 'emma.santos@gmail.com', '23-09234', '09123456813', 'password123'),
('Lucas Fernandez', 'lucas.fernandez@gmail.com', '23-09235', '09123456814', 'password123'),
('Mia Lopez', 'mia.lopez@gmail.com', '23-09236', '09123456815', 'password123'),
('Hannah Cruz', 'hannah.cruz@gmail.com', '23-09237', '09123456816', 'password123'),
('Noah Bautista', 'noah.bautista@gmail.com', '23-09238', '09123456817', 'password123'),
('Ava Santos', 'ava.santos@gmail.com', '23-09239', '09123456818', 'password123'),
('Ethan Garcia', 'ethan.garcia@gmail.com', '23-09240', '09123456819', 'password123'),
('Isabella Reyes', 'isabella.reyes@gmail.com', '23-09241', '09123456820', 'password123'),
('Jacob Ramirez', 'jacob.ramirez@gmail.com', '23-09242', '09123456821', 'password123'),
('Sophia Castillo', 'sophia.castillo@gmail.com', '23-09243', '09123456822', 'password123'),
('Mason Tan', 'mason.tan@gmail.com', '23-09244', '09123456823', 'password123'),
('Charlotte Lopez', 'charlotte.lopez@gmail.com', '23-09245', '09123456824', 'password123'),
('Logan Mendoza', 'logan.mendoza@gmail.com', '23-09246', '09123456825', 'password123'),
('Amelia Fernandez', 'amelia.fernandez@gmail.com', '23-09247', '09123456826', 'password123'),
('Benjamin Ortiz', 'benjamin.ortiz@gmail.com', '23-09248', '09123456827', 'password123'),
('Ella Marquez', 'ella.marquez@gmail.com', '23-09249', '09123456828', 'password123');

-- Insert Data into Applications Table
INSERT INTO applications (scholarship_id, student_id, status, application_date) VALUES
(1, 1, 'Submitted', '2024-10-15'),
(2, 2, 'In Progress', '2024-11-01'),
(3, 3, 'Not Started', '2024-10-05'),
(4, 4, 'Submitted', '2024-10-10'),
(5, 5, 'Awarded', '2024-09-30'),
(1, 6, 'Rejected', '2024-10-20'),
(7, 7, 'In Progress', '2024-11-10'),
(8, 8, 'Not Started', '2024-11-01'),
(9, 9, 'Submitted', '2024-10-15'),
(10, 10, 'Not Started', '2024-10-12'),
(1, 11, 'Submitted', '2024-10-11'),
(2, 12, 'In Progress', '2024-11-05'),
(3, 13, 'Not Started', '2024-10-12'),
(4, 14, 'Submitted', '2024-10-20'),
(5, 15, 'Awarded', '2024-09-25'),
(1, 16, 'Rejected', '2024-10-30'),
(7, 17, 'In Progress', '2024-11-15'),
(8, 18, 'Not Started', '2024-11-03'),
(9, 19, 'Submitted', '2024-10-18'),
(10, 20, 'Not Started', '2024-10-13'),
(1, 21, 'Submitted', '2024-10-14'),
(2, 22, 'In Progress', '2024-11-02'),
(3, 23, 'Not Started', '2024-10-07'),
(4, 24, 'Submitted', '2024-10-08'),
(5, 25, 'Awarded', '2024-09-29'),
(1, 26, 'Rejected', '2024-10-19'),
(7, 27, 'In Progress', '2024-11-08'),
(8, 28, 'Not Started', '2024-11-06'),
(9, 29, 'Submitted', '2024-10-17'),
(10, 30, 'Not Started', '2024-10-09');


-- Insert Data into Scholarship Requirements Table
INSERT INTO scholarship_requirements (scholarship_id, requirement_text) VALUES
(1, 'GPA above 3.0'),
(1, 'Proof of income'),
(2, 'OFW parent'),
(2, 'GPA above 2.5'),
(2, 'Proof of enrollment'),
(3, 'GPA above 3.5'),
(3, 'STEM course enrollment'),
(4, 'GPA above 3.0'),
(4, 'Proof of financial need'),
(5, 'Engineering or business course'),
(5, 'GPA above 3.2'),
(5, 'Recommendation letter'),
(6, 'GPA above 3.3'),
(6, 'Essay on career goals'),
(7, 'Partner school enrollment'),
(7, 'GPA above 3.0'),
(7, 'Financial need proof'),
(8, 'Medical school enrollment'),
(8, 'GPA above 3.2'),
(9, 'Healthcare field enrollment'),
(9, 'GPA above 3.0'),
(10, 'Leadership experience'),
(10, 'GPA above 3.4'),
(10, 'Essay on community impact');

-- Insert Data into Application Status History Table
INSERT INTO application_status_history (application_id, status) VALUES
(1, 'Submitted'),
(1, 'In Progress'),
(2, 'In Progress'),
(3, 'Not Started'),
(4, 'Submitted'),
(5, 'Awarded'),
(6, 'Rejected'),
(7, 'In Progress'),
(8, 'Not Started'),
(9, 'Submitted'),
(10, 'Not Started');

-- Insert Data into Reviewers Table
INSERT INTO reviewers (name, email) VALUES
('Dr. John Smith', 'john.smith@example.com'),
('Ms. Jane Doe', 'jane.doe@example.com'),
('Prof. Albert Johnson', 'albert.johnson@example.com'),
('Dr. Sarah Lee', 'sarah.lee@example.com'),
('Mr. Paul Adams', 'paul.adams@example.com');

-- Insert Data into Application Reviews Table
INSERT INTO application_reviews (application_id, reviewer_id, score, comments) VALUES
(1, 1, 85, 'Strong application, but needs more community involvement.'),
(2, 2, 78, 'Good academic record, but lower GPA.'),
(3, 3, 92, 'Excellent qualifications.'),
(4, 4, 88, 'Very promising candidate.'),
(5, 5, 90, 'Well-rounded application.'),
(6, 1, 70, 'Financial need is significant.'),
(7, 2, 75, 'Decent application, but GPA is borderline.'),
(8, 3, 80, 'Shows potential but lacks extracurriculars.'),
(9, 4, 95, 'Outstanding candidate.'),
(10, 5, 82, 'Good academic standing.');

