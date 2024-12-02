-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 11:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_scholarshiptracker`
--
-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `announcement` text NOT NULL,
  `date_posted` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `subject`, `announcement`, `date_posted`) VALUES
(4, 'Scholarship Merit Award', 'You are qualified to this scholarships', '2024-12-02');

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `application_id` int(11) NOT NULL,
  `application_no` varchar(20) NOT NULL,
  `schema_id` int(11) DEFAULT NULL,
  `scholarship_type` varchar(100) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `applicant_name` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sr_code` varchar(20) NOT NULL,
  `year_level` varchar(20) NOT NULL,
  `apply_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`application_id`, `application_no`, `schema_id`, `scholarship_type`, `photo_path`, `applicant_name`, `date_of_birth`, `gender`, `mobile_number`, `email`, `sr_code`, `year_level`, `apply_date`, `status`) VALUES
(1, '9876', 1, 'Academic Excellence', NULL, 'Joan Briones', '2000-01-01', 'Female', '09778455634', '22-36298@g.batstate-u.edu.ph', '22-36298', '1st Year', '2024-11-23 16:00:00', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `application_id` int(11) NOT NULL,
  `scholarship_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `status` enum('Not Started','In Progress','Submitted','Awarded','Rejected') DEFAULT 'Not Started',
  `application_date` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `scholarship_id`, `student_id`, `status`, `application_date`, `updated_at`) VALUES
(2, 2, 2, 'In Progress', '2024-11-01', '2024-11-22 04:57:05'),
(3, 3, 3, 'Not Started', '2024-10-05', '2024-11-22 04:57:05'),
(4, 4, 4, 'Submitted', '2024-10-10', '2024-11-22 04:57:05'),
(5, 5, 5, 'Awarded', '2024-09-30', '2024-11-22 04:57:05'),
(7, 7, 7, 'In Progress', '2024-11-10', '2024-11-22 04:57:05'),
(8, 8, 8, 'Not Started', '2024-11-01', '2024-11-22 04:57:05'),
(9, 9, 9, 'Submitted', '2024-10-15', '2024-11-22 04:57:05'),
(10, 10, 10, 'Not Started', '2024-10-12', '2024-11-22 04:57:05'),
(12, 2, 12, 'In Progress', '2024-11-05', '2024-11-22 04:57:05'),
(13, 3, 13, 'Not Started', '2024-10-12', '2024-11-22 04:57:05'),
(14, 4, 14, 'Submitted', '2024-10-20', '2024-11-22 04:57:05'),
(15, 5, 15, 'Awarded', '2024-09-25', '2024-11-22 04:57:05'),
(17, 7, 17, 'In Progress', '2024-11-15', '2024-11-22 04:57:05'),
(18, 8, 18, 'Not Started', '2024-11-03', '2024-11-22 04:57:05'),
(19, 9, 19, 'Submitted', '2024-10-18', '2024-11-22 04:57:05'),
(20, 10, 20, 'Not Started', '2024-10-13', '2024-11-22 04:57:05'),
(22, 2, 22, 'In Progress', '2024-11-02', '2024-11-22 04:57:05'),
(23, 3, 23, 'Not Started', '2024-10-07', '2024-11-22 04:57:05'),
(24, 4, 24, 'Submitted', '2024-10-08', '2024-11-22 04:57:05'),
(25, 5, 25, 'Awarded', '2024-09-29', '2024-11-22 04:57:05'),
(27, 7, 27, 'In Progress', '2024-11-08', '2024-11-22 04:57:05'),
(28, 8, 28, 'Not Started', '2024-11-06', '2024-11-22 04:57:05'),
(29, 9, 29, 'Submitted', '2024-10-17', '2024-11-22 04:57:05'),
(30, 10, 30, 'Not Started', '2024-10-09', '2024-11-22 04:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `application_documents`
--

CREATE TABLE `application_documents` (
  `document_id` int(11) NOT NULL,
  `application_id` int(11) DEFAULT NULL,
  `document_path` varchar(255) NOT NULL,
  `document_type` varchar(50) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_history`
--

CREATE TABLE `application_history` (
  `id` int(11) NOT NULL,
  `application_no` varchar(20) NOT NULL,
  `scholarship_type` varchar(100) NOT NULL,
  `applicant_name` varchar(100) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `apply_date` date NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `photo_path` varchar(255) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sr_code` varchar(100) NOT NULL,
  `year_level` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_reviews`
--

CREATE TABLE `application_reviews` (
  `review_id` int(11) UNSIGNED NOT NULL,
  `application_id` int(11) DEFAULT NULL,
  `reviewer_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application_reviews`
--

INSERT INTO `application_reviews` (`review_id`, `application_id`, `reviewer_id`, `score`, `comments`, `review_date`) VALUES
(2, 2, 2, 78, 'Good academic record, but lower GPA.', '2024-11-22 04:57:05'),
(3, 3, 3, 92, 'Excellent qualifications.', '2024-11-22 04:57:05'),
(4, 4, 4, 88, 'Very promising candidate.', '2024-11-22 04:57:05'),
(5, 5, 5, 90, 'Well-rounded application.', '2024-11-22 04:57:05'),
(7, 7, 2, 75, 'Decent application, but GPA is borderline.', '2024-11-22 04:57:05'),
(8, 8, 3, 80, 'Shows potential but lacks extracurriculars.', '2024-11-22 04:57:05'),
(9, 9, 4, 95, 'Outstanding candidate.', '2024-11-22 04:57:05'),
(10, 10, 5, 82, 'Good academic standing.', '2024-11-22 04:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `application_status_history`
--

CREATE TABLE `application_status_history` (
  `history_id` int(11) NOT NULL,
  `application_id` int(11) DEFAULT NULL,
  `status` enum('Not Started','In Progress','Submitted','Awarded','Rejected') NOT NULL,
  `status_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application_status_history`
--

INSERT INTO `application_status_history` (`history_id`, `application_id`, `status`, `status_date`) VALUES
(3, 2, 'In Progress', '2024-11-22 04:57:05'),
(4, 3, 'Not Started', '2024-11-22 04:57:05'),
(5, 4, 'Submitted', '2024-11-22 04:57:05'),
(6, 5, 'Awarded', '2024-11-22 04:57:05'),
(8, 7, 'In Progress', '2024-11-22 04:57:05'),
(9, 8, 'Not Started', '2024-11-22 04:57:05'),
(10, 9, 'Submitted', '2024-11-22 04:57:05'),
(11, 10, 'Not Started', '2024-11-22 04:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`) VALUES
(24, 'Cute ba me?', 'yes na yes naman'),
(27, 'matangkad ba me?', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `featured_scholar`
--

CREATE TABLE `featured_scholar` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `year_graduated` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `featured_scholar`
--

INSERT INTO `featured_scholar` (`id`, `subject`, `course`, `year_graduated`, `message`, `status`, `created_at`) VALUES
(1, 'Scholarship', 'BSIT', '2024-2025', 'mmmmm', 'Approved', '2024-12-02 03:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `featured_scholars`
--

CREATE TABLE `featured_scholars` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `year_graduated` year(4) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `featured_scholars`
--

INSERT INTO `featured_scholars` (`id`, `subject`, `course`, `year_graduated`, `message`, `status`) VALUES
(10, 'Scholarship', 'BSIT', '2024', 'n', 'Approved'),
(11, 'Scholarship', 'BSIT', '2024', 'n', 'Approved'),
(12, 'Scholarship', 'BSIT', '2024', 'm', 'Approved'),
(13, 'Scholarship', 'BSIT', '2024', 'm', 'Approved'),
(14, 'Scholarship', 'BSIT', '2024', ',,', 'Approved'),
(15, 'Scholarship', 'BSIT', '2024', 'hi', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `scholarship` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewers`
--

CREATE TABLE `reviewers` (
  `reviewer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviewers`
--

INSERT INTO `reviewers` (`reviewer_id`, `name`, `email`) VALUES
(1, 'Dr. John Smith', 'john.smith@example.com'),
(2, 'Ms. Jane Doe', 'jane.doe@example.com'),
(3, 'Prof. Albert Johnson', 'albert.johnson@example.com'),
(4, 'Dr. Sarah Lee', 'sarah.lee@example.com'),
(5, 'Mr. Paul Adams', 'paul.adams@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `scholars`
--

CREATE TABLE `scholars` (
  `sr_code` varchar(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `year_level` varchar(255) DEFAULT NULL,
  `scholarship` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholars`
--

INSERT INTO `scholars` (`sr_code`, `name`, `course`, `year_level`, `scholarship`) VALUES
('23-36222', 'Jayden Briones', 'BSIT', '2nd Year', 'DOST');

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `scholarship_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarships`
--

INSERT INTO `scholarships` (`scholarship_id`, `name`, `description`, `deadline`, `requirements`, `created_at`, `updated_at`, `status`) VALUES
(2, 'OWWA Scholarships', 'Scholarship for dependents of OFWs provided by OWWA.', '2025-01-10', 'OFW parent, GPA above 2.5, Proof of enrollment', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(3, 'DOST Scholarship', 'Science and technology scholarship for students with a strong academic record.', '2024-12-20', 'GPA above 3.5, STEM course enrollment', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(4, 'SM Scholarship', 'A scholarship for financially challenged students with good academic standing.', '2024-11-30', 'GPA above 3.0, Proof of financial need', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(5, 'Aboitiz Scholarship Program', 'Supports students pursuing careers in engineering and business.', '2025-01-25', 'Engineering or business course, GPA above 3.2, Recommendation letter', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(6, 'Megaworld Scholarship', 'A scholarship for students in partner schools demonstrating academic excellence.', '2025-02-15', 'GPA above 3.3, Essay on career goals', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(7, 'Security Bank Scholarship', 'Financial assistance for deserving students in partner schools.', '2024-12-05', 'Partner school enrollment, GPA above 3.0, Financial need proof', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(8, 'CHED Medical Scholarship', 'Scholarship for medical students under the CHED program.', '2024-12-31', 'Medical school enrollment, GPA above 3.2', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(9, 'DOH Pre-Service Scholarship', 'A pre-service scholarship for healthcare students under DOH.', '2024-11-10', 'Healthcare field enrollment, GPA above 3.0, Service agreement', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(10, 'Ayala Foundation Scholarship', 'Scholarship for students with strong academic and leadership skills.', '2025-03-01', 'Leadership experience, GPA above 3.4, Essay on community impact', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(11, 'Hawak Kamay Scholarship', 'Support for students in financial need who show academic promise.', '2024-10-30', 'GPA above 2.8, Proof of financial need', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(12, 'CHED Tulong Dunong Scholarship', 'Financial assistance program for eligible college students.', '2025-01-05', 'GPA above 2.5, Income proof, Recommendation letter', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(13, 'Iskolar ni Juan', 'Scholarship for students in public colleges with good academic standing.', '2025-02-20', 'Public school enrollment, GPA above 3.0', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(14, 'Landbank Scholarship', 'Scholarship for students in agriculture or related fields.', '2024-12-15', 'Agriculture-related course, GPA above 3.0, Service agreement', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(15, 'PHINMA Scholarship', 'Scholarship for students in PHINMA partner schools with financial need.', '2025-01-15', 'PHINMA school enrollment, Financial need, Essay', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(16, 'CHED CoScho Scholarship', 'Co-sponsored scholarship under CHED for deserving students.', '2025-03-10', 'GPA above 3.2, Sponsorship agreement', '2024-11-22 04:57:05', '2024-11-22 04:57:05', 'active'),
(17, 'Merit Scholarship', 'For academically excellent students', '2024-12-31', 'GWA of 1.75 or higher', '2024-11-30 13:59:13', '2024-11-30 13:59:13', 'active'),
(18, 'Athletic Scholarship', 'For student athletes', '2024-12-31', 'Member of varsity team', '2024-11-30 13:59:13', '2024-11-30 13:59:13', 'active'),
(19, 'Financial Aid', 'For financially challenged students', '2024-12-31', 'Income certificate required', '2024-11-30 13:59:13', '2024-11-30 13:59:13', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_requests`
--

CREATE TABLE `scholarship_requests` (
  `request_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `sr_code` varchar(50) NOT NULL,
  `scholarship_id` int(11) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year_level` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_requests`
--

INSERT INTO `scholarship_requests` (`request_id`, `student_name`, `sr_code`, `scholarship_id`, `course`, `year_level`, `status`, `request_date`) VALUES
(10, 'Jane Smith', '21-67890', 2, 'BS Information Technology', '2nd Year', 'approved', '2024-11-30 14:09:26'),
(11, 'Bob Wilson', '19-11111', 3, 'BS Engineering', '4th Year', 'pending', '2024-11-30 14:09:26');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_requirements`
--

CREATE TABLE `scholarship_requirements` (
  `requirement_id` int(11) NOT NULL,
  `scholarship_id` int(11) DEFAULT NULL,
  `requirement_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_requirements`
--

INSERT INTO `scholarship_requirements` (`requirement_id`, `scholarship_id`, `requirement_text`) VALUES
(3, 2, 'OFW parent'),
(4, 2, 'GPA above 2.5'),
(5, 2, 'Proof of enrollment'),
(6, 3, 'GPA above 3.5'),
(7, 3, 'STEM course enrollment'),
(8, 4, 'GPA above 3.0'),
(9, 4, 'Proof of financial need'),
(10, 5, 'Engineering or business course'),
(11, 5, 'GPA above 3.2'),
(12, 5, 'Recommendation letter'),
(13, 6, 'GPA above 3.3'),
(14, 6, 'Essay on career goals'),
(15, 7, 'Partner school enrollment'),
(16, 7, 'GPA above 3.0'),
(17, 7, 'Financial need proof'),
(18, 8, 'Medical school enrollment'),
(19, 8, 'GPA above 3.2'),
(20, 9, 'Healthcare field enrollment'),
(21, 9, 'GPA above 3.0'),
(22, 10, 'Leadership experience'),
(23, 10, 'GPA above 3.4'),
(24, 10, 'Essay on community impact');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_schema`
--

CREATE TABLE `scholarship_schema` (
  `schema_id` int(11) NOT NULL,
  `scholarship_type` varchar(100) NOT NULL,
  `grade_campus` varchar(100) NOT NULL,
  `year_scholarship` varchar(20) NOT NULL,
  `category` varchar(50) NOT NULL,
  `criteria` text NOT NULL,
  `submission_deadline` date NOT NULL,
  `required_documents` text NOT NULL,
  `description` text NOT NULL,
  `amount_per_sem` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'Open',
  `published_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_schema`
--

INSERT INTO `scholarship_schema` (`schema_id`, `scholarship_type`, `grade_campus`, `year_scholarship`, `category`, `criteria`, `submission_deadline`, `required_documents`, `description`, `amount_per_sem`, `status`, `published_date`) VALUES
(1, 'Academic Excellence', '1st Year BSU-Lipa', '2024-2025', 'Merit-based', 'Applicants must have an overall average of 90% or above in their most recent academic year or term.', '2024-11-15', 'Birth Certificate, Report Card, Enrollment Form', 'Rewards outstanding students who consistently achieve high grades', 3000.00, 'Open', '2024-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `school_year` varchar(9) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `school_year` varchar(9) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `school_year`, `semester`, `status`, `created_at`) VALUES
(4, '2024-2025', 'Summer', 'Active', '2024-12-01 15:46:51'),
(8, '2023-2024', '2nd', 'Active', '2024-12-02 09:13:57');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sr_code` varchar(100) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `sr_code`, `mobile_number`, `password`) VALUES
(1, 'Jose Cruz', 'jose.cruz@gmail.com', '21-20930', '09123456789', 'password123'),
(2, 'Maria Santos', 'maria.santos@gmail.com', '21-89012', '09123456780', 'password123'),
(3, 'Mark Bautista', 'mark.bautista@gmail.com', '21-23456', '09123456781', 'password123'),
(4, 'Ana Dela Cruz', 'ana.delacruz@gmail.com', '21-34567', '09123456782', 'password123'),
(5, 'Carla Ramirez', 'carla.ramirez@gmail.com', '22-45678', '09123456783', 'password123'),
(6, 'Miguel Reyes', 'miguel.reyes@gmail.com', '21-56789', '09123456784', 'password123'),
(7, 'Isabel Flores', 'isabel.flores@gmail.com', '21-67890', '09123456785', 'password123'),
(8, 'Paolo Garcia', 'paolo.garcia@gmail.com', '21-78901', '09123456786', 'password123'),
(9, 'Christine Lim', 'christine.lim@gmail.com', '21-89012', '09123456787', 'password123'),
(10, 'Juan Dela Cruz', 'juan.delacruz@gmail.com', '21-90123', '09123456788', 'password123'),
(11, 'Carlos Santos', 'carlos.santos@gmail.com', '21-01234', '09123456789', 'password123'),
(12, 'Julia Roldan', 'julia.roldan@gmail.com', '22-12345', '09123456790', 'password123'),
(13, 'Ramon Lopez', 'ramon.lopez@gmail.com', '21-23456', '09123456791', 'password123'),
(14, 'Teresa Castillo', 'teresa.castillo@gmail.com', '21-34567', '09123456792', 'password123'),
(15, 'Eric Mendoza', 'eric.mendoza@gmail.com', '21-45678', '09123456793', 'password123'),
(16, 'Angelica Tan', 'angelica.tan@gmail.com', '21-56789', '09123456794', 'password123'),
(17, 'Jerome Alcantara', 'jerome.alcantara@gmail.com', '21-67890', '09123456795', 'password123'),
(18, 'Lyka Mendoza', 'lyka.mendoza@gmail.com', '21-78901', '09123456796', 'password123'),
(19, 'Carlos Aquino', 'carlos.aquino@gmail.com', '21-89012', '09123456797', 'password123'),
(20, 'Karla Garcia', 'karla.garcia@gmail.com', '22-90123', '09123456798', 'password123'),
(21, 'Miguel Fernandez', 'miguel.fernandez@gmail.com', '21-01234', '09123456799', 'password123'),
(22, 'Roselle Bautista', 'roselle.bautista@gmail.com', '21-12345', '09123456800', 'password123'),
(23, 'Patrick Reyes', 'patrick.reyes@gmail.com', '21-23456', '09123456801', 'password123'),
(24, 'Angela Marquez', 'angela.marquez@gmail.com', '22-34567', '09123456802', 'password123'),
(25, 'Emilio Navarro', 'emilio.navarro@gmail.com', '21-45678', '09123456803', 'password123'),
(26, 'Diana Santos', 'diana.santos@gmail.com', '21-56789', '09123456804', 'password123'),
(27, 'Leah Cortez', 'leah.cortez@gmail.com', '21-67890', '09123456805', 'password123'),
(28, 'Felix Cruz', 'felix.cruz@gmail.com', '21-78901', '09123456806', 'password123'),
(29, 'Sandra Diaz', 'sandra.diaz@gmail.com', '22-89012', '09123456807', 'password123'),
(30, 'Raymond Mercado', 'raymond.mercado@gmail.com', '21-90123', '09123456808', 'password123'),
(31, 'Carmen Ortiz', 'carmen.ortiz@gmail.com', '21-01234', '09123456809', 'password123'),
(32, 'Sophia Cruz', 'sophia.cruz@gmail.com', '23-09231', '09123456810', 'password123'),
(33, 'Liam Garcia', 'liam.garcia@gmail.com', '23-09232', '09123456811', 'password123'),
(34, 'Oliver Reyes', 'oliver.reyes@gmail.com', '23-09233', '09123456812', 'password123'),
(35, 'Emma Santos', 'emma.santos@gmail.com', '23-09234', '09123456813', 'password123'),
(36, 'Lucas Fernandez', 'lucas.fernandez@gmail.com', '23-09235', '09123456814', 'password123'),
(37, 'Mia Lopez', 'mia.lopez@gmail.com', '23-09236', '09123456815', 'password123'),
(38, 'Hannah Cruz', 'hannah.cruz@gmail.com', '23-09237', '09123456816', 'password123'),
(39, 'Noah Bautista', 'noah.bautista@gmail.com', '23-09238', '09123456817', 'password123'),
(40, 'Ava Santos', 'ava.santos@gmail.com', '23-09239', '09123456818', 'password123'),
(41, 'Ethan Garcia', 'ethan.garcia@gmail.com', '23-09240', '09123456819', 'password123'),
(42, 'Isabella Reyes', 'isabella.reyes@gmail.com', '23-09241', '09123456820', 'password123'),
(43, 'Jacob Ramirez', 'jacob.ramirez@gmail.com', '23-09242', '09123456821', 'password123'),
(44, 'Sophia Castillo', 'sophia.castillo@gmail.com', '23-09243', '09123456822', 'password123'),
(45, 'Mason Tan', 'mason.tan@gmail.com', '23-09244', '09123456823', 'password123'),
(46, 'Charlotte Lopez', 'charlotte.lopez@gmail.com', '23-09245', '09123456824', 'password123'),
(47, 'Logan Mendoza', 'logan.mendoza@gmail.com', '23-09246', '09123456825', 'password123'),
(48, 'Amelia Fernandez', 'amelia.fernandez@gmail.com', '23-09247', '09123456826', 'password123'),
(49, 'Benjamin Ortiz', 'benjamin.ortiz@gmail.com', '23-09248', '09123456827', 'password123'),
(50, 'Ella Marquez', 'ella.marquez@gmail.com', '23-09249', '09123456828', 'password123'),
(51, 'Joan Briones', '23-36298@g.batstate-u.edu.ph', '23-36298', '09668744635', 'password123'),
(52, 'justin katigbak', '23-37298@g.batstate-u.edu.ph', '23-37298', '09998744635', 'password123'),
(53, 'MARIA BRIONES', '23-36398@g.batstate-u.edu.ph', '23-36398', '09798744635', 'passwordko'),
(54, 'Jose Katigbak', '23-37398@g.batstate-u.edu.ph', '23-37398', '09798744635', 'wala lang'),
(55, 'Joan Briones', 'qti@gmail.com', '23-36299', '09778744635', '12345'),
(56, 'Ariana Grande', 'ariana@gmail.com', '23-36291', '09977325864', 'joanqt'),
(57, 'Anne Trisha', 'trishamarzo@gmail.com', '23-36297', '09977325865', 'joanqt'),
(58, 'jezrev labay', 'jezrev@gmail.com', '20-34567', '09654167419', 'jezrev'),
(59, 'Jayden Mark', 'briones@gmail.com', '21-39899', '09363363611', 'jaydenpanget'),
(60, 'Justin Kyle Katigbak', 'justin.kyle@gmail.com', '23-36278', '09223363611', 'joanqt'),
(61, 'Johnver Briones', 'johnverbriones@gmail.com', '20-20222', '0977238546', 'panget'),
(62, 'Sky Belle', 'skybelle@gmail.com', '21-21234', '09112232322', 'skybelle'),
(63, 'Joana Marie', 'joana-b@099gmail.com', '12-22344', '09876545455', 'marie'),
(64, 'Sarah Santos', 'sarahs@gmail.com', '22-89018', '09123486780', 'password123'),
(65, 'Joan Katigbak', 'joankatigbak@gmail.com', '21-23232', '09787787811', 'justin'),
(66, 'Joed Katigbak', 'joedkatigbak@gmail.com', '23-23232', '09887787811', 'oklang');

-- --------------------------------------------------------

--
-- Table structure for table `student_assessment`
--

CREATE TABLE `student_assessment` (
  `id` int(11) NOT NULL,
  `school_year` varchar(9) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `gwa` decimal(4,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `assessed_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_account`
--

CREATE TABLE `users_account` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sr_code` varchar(50) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_account`
--

INSERT INTO `users_account` (`id`, `full_name`, `email`, `sr_code`, `mobile_number`, `password`, `role`, `created_at`) VALUES
(3, 'Joan Brioness', '23-36298@g.batstate-u.edu.ph', '23-36298', '09668744635', '$2y$10$7LLE6xgDnwcJWEcyycL8qegpj6U7DgDPHAfVhZ9yGR2GcLBOeCtNy', 'student', '2024-12-01 16:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_application`
--

CREATE TABLE `user_application` (
  `id` int(11) NOT NULL,
  `app_no` varchar(20) NOT NULL,
  `scholarship_type` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `apply_date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `description` text NOT NULL,
  `author` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_password_hash` varchar(255) DEFAULT NULL,
  `new_password_hash` varchar(255) DEFAULT NULL,
  `change_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_students`
--

CREATE TABLE `user_students` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sr_code` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_students`
--

INSERT INTO `user_students` (`id`, `full_name`, `email`, `sr_code`, `password`, `created_at`) VALUES
(1, 'Joan Brioness', '23-36298@g.batstate-u.edu.ph', '23-36298 ', '$2y$10$5vmhlek04xJYaaxZrvnQJOGRQ5AzGAv4kEkz1DxshfDTt/fqfRxdK', '2024-12-01 18:23:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`application_id`),
  ADD UNIQUE KEY `application_no` (`application_no`),
  ADD KEY `schema_id` (`schema_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `scholarship_id` (`scholarship_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `application_documents`
--
ALTER TABLE `application_documents`
  ADD PRIMARY KEY (`document_id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `application_history`
--
ALTER TABLE `application_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `application_no` (`application_no`);

--
-- Indexes for table `application_reviews`
--
ALTER TABLE `application_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `application_id` (`application_id`),
  ADD KEY `reviewer_id` (`reviewer_id`);

--
-- Indexes for table `application_status_history`
--
ALTER TABLE `application_status_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `application_id` (`application_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featured_scholar`
--
ALTER TABLE `featured_scholar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featured_scholars`
--
ALTER TABLE `featured_scholars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviewers`
--
ALTER TABLE `reviewers`
  ADD PRIMARY KEY (`reviewer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `scholars`
--
ALTER TABLE `scholars`
  ADD PRIMARY KEY (`sr_code`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`scholarship_id`);

--
-- Indexes for table `scholarship_requests`
--
ALTER TABLE `scholarship_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `scholarship_id` (`scholarship_id`);

--
-- Indexes for table `scholarship_requirements`
--
ALTER TABLE `scholarship_requirements`
  ADD PRIMARY KEY (`requirement_id`),
  ADD KEY `scholarship_id` (`scholarship_id`);

--
-- Indexes for table `scholarship_schema`
--
ALTER TABLE `scholarship_schema`
  ADD PRIMARY KEY (`schema_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_assessment`
--
ALTER TABLE `student_assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_account`
--
ALTER TABLE `users_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `sr_code` (`sr_code`);

--
-- Indexes for table `user_application`
--
ALTER TABLE `user_application`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_students`
--
ALTER TABLE `user_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `sr_code` (`sr_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `application_documents`
--
ALTER TABLE `application_documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_history`
--
ALTER TABLE `application_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_reviews`
--
ALTER TABLE `application_reviews`
  MODIFY `review_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `application_status_history`
--
ALTER TABLE `application_status_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `featured_scholar`
--
ALTER TABLE `featured_scholar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `featured_scholars`
--
ALTER TABLE `featured_scholars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewers`
--
ALTER TABLE `reviewers`
  MODIFY `reviewer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `scholarship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `scholarship_requests`
--
ALTER TABLE `scholarship_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `scholarship_requirements`
--
ALTER TABLE `scholarship_requirements`
  MODIFY `requirement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `scholarship_schema`
--
ALTER TABLE `scholarship_schema`
  MODIFY `schema_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `student_assessment`
--
ALTER TABLE `student_assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_account`
--
ALTER TABLE `users_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_application`
--
ALTER TABLE `user_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_students`
--
ALTER TABLE `user_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`schema_id`) REFERENCES `scholarship_schema` (`schema_id`);

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`scholarship_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `application_documents`
--
ALTER TABLE `application_documents`
  ADD CONSTRAINT `application_documents_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`application_id`);

--
-- Constraints for table `application_reviews`
--
ALTER TABLE `application_reviews`
  ADD CONSTRAINT `application_reviews_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`application_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_reviews_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `reviewers` (`reviewer_id`) ON DELETE CASCADE;

--
-- Constraints for table `application_status_history`
--
ALTER TABLE `application_status_history`
  ADD CONSTRAINT `application_status_history_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`application_id`) ON DELETE CASCADE;

--
-- Constraints for table `scholarship_requests`
--
ALTER TABLE `scholarship_requests`
  ADD CONSTRAINT `scholarship_requests_ibfk_1` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`scholarship_id`);

--
-- Constraints for table `scholarship_requirements`
--
ALTER TABLE `scholarship_requirements`
  ADD CONSTRAINT `scholarship_requirements_ibfk_1` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`scholarship_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
