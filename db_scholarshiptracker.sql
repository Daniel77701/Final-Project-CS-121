-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2024 at 02:13 AM
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
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_notifications`
--

INSERT INTO `admin_notifications` (`id`, `title`, `message`, `type`, `link`, `timestamp`, `is_read`) VALUES
(1, 'New Feedback Received', 'New feedback from sophia.cruz@gmail.com: sa', 'feedback', 'feedback.php', '2024-12-06 20:36:32', 0),
(2, 'New Feedback Received', 'New feedback from sophia.cruz@gmail.com: as', 'feedback', 'feedback.php', '2024-12-06 20:36:40', 0),
(3, 'New Feedback Received', 'New feedback from lucas.fernandez@gmail.com: asasa', 'feedback', 'feedback.php', '2024-12-06 20:38:18', 0),
(4, 'New Feedback Received', 'New feedback from lucas.fernandez@gmail.com: Nice system', 'feedback', 'feedback.php', '2024-12-06 20:40:03', 0),
(5, 'New Feedback Received', 'New feedback from lucas.fernandez@gmail.com: asa', 'feedback', 'feedback.php', '2024-12-06 20:40:17', 0),
(6, 'New Feedback Received', 'New feedback from lucas.fernandez@gmail.com: assa', 'feedback', 'feedback.php', '2024-12-06 20:40:25', 0),
(7, 'New Feedback Received', 'New feedback from lucas.fernandez@gmail.com: wait', 'feedback', 'feedback.php', '2024-12-06 20:40:33', 0),
(8, 'New Feedback Received', 'New feedback from lucas.fernandez@gmail.com: wait', 'feedback', 'feedback.php', '2024-12-06 20:40:38', 0),
(9, 'New Feedback Received', 'New feedback from lucas.fernandez@gmail.com: wait', 'feedback', 'feedback.php', '2024-12-06 20:40:43', 0),
(10, 'New Feedback Received', 'New feedback from lucas.fernandez@gmail.com: please work', 'feedback', 'feedback.php', '2024-12-06 20:47:19', 0),
(11, 'New Feedback Received', 'New feedback from miguel.reyes@gmail.com: nice system', 'feedback', 'feedback.php', '2024-12-07 00:46:04', 0);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `announcement` text NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `subject`, `announcement`, `date_posted`, `status`) VALUES
(12, 'OWWA Scholarship', 'Give the deadlines today. Give all the needed documents. ', '2024-12-06 14:19:13', 'Active');

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
(10, 10, 10, 'Not Started', '2024-10-12', '2024-11-22 04:57:05'),
(12, 2, 12, 'In Progress', '2024-11-05', '2024-11-22 04:57:05'),
(15, 5, 15, 'Awarded', '2024-09-25', '2024-11-22 04:57:05'),
(20, 10, 20, 'Not Started', '2024-10-13', '2024-11-22 04:57:05'),
(22, 2, 22, 'In Progress', '2024-11-02', '2024-11-22 04:57:05'),
(24, 4, 24, 'Submitted', '2024-10-08', '2024-11-22 04:57:05'),
(29, 9, 29, 'Submitted', '2024-10-17', '2024-11-22 04:57:05');

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
(11, 10, 'Not Started', '2024-11-22 04:57:05');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `status`, `created_at`) VALUES
(28, 'Can I be a scholar?', 'Yes, you can', 'Active', '2024-12-06 13:30:15'),
(32, 'Pleasee', 'What is thiss', 'Inactive', '2024-12-07 00:14:42'),
(33, 'Are you working now?', 'YEs', 'Inactive', '2024-12-07 00:15:36'),
(34, 'wait for real?', 'Maybe', 'Inactive', '2024-12-07 00:15:46'),
(35, 'Tingnan mo kagara', 'Niceeee', 'Inactive', '2024-12-07 00:17:39'),
(36, 'does it work', 'yes actually', 'Inactive', '2024-12-07 00:20:46'),
(37, 'Does this Scholarship Tracker System only for BSU Students?', 'It is exclusive for BSU students', 'Active', '2024-12-07 00:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `featured_scholars`
--

CREATE TABLE `featured_scholars` (
  `id` int(11) NOT NULL,
  `sr_code` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `featured_scholars`
--

INSERT INTO `featured_scholars` (`id`, `sr_code`, `message`, `status`, `created_at`) VALUES
(4, '23-09236', '1400/1450 Exam Score', 'Active', '2024-12-06 07:31:07'),
(7, '22-90123', '1350/1400 Exam Score', 'Active', '2024-12-06 11:29:45'),
(8, '21-34567', '1360/1500 Exam Score', 'Active', '2024-12-06 13:49:46'),
(9, '21-20930', '1900/2000', 'Active', '2024-12-06 14:42:07');

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

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `scholarship`, `message`, `name`, `course`, `email`, `created_at`) VALUES
(7, '', 'Nice system', '', '', 'lucas.fernandez@gmail.com', '2024-12-06 20:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `status`, `created_at`) VALUES
(1, 'New FAQ added: ggg', 'unread', '2024-12-02 13:41:41'),
(2, 'FAQ updated: ggg', 'unread', '2024-12-02 13:51:00'),
(3, 'FAQ updated: sasasasas', 'unread', '2024-12-02 13:51:04'),
(4, 'FAQ deleted: sasasasas', 'unread', '2024-12-02 13:51:06'),
(5, 'New FAQ added: yess gumana na din AGHAHAHAH', 'unread', '2024-12-02 13:51:13'),
(6, 'FAQ updated: yess gumana na din AGHAHAHAH', 'unread', '2024-12-02 13:51:50'),
(7, 'FAQ deleted: yess gumana na din AGHAHAHAH', 'unread', '2024-12-02 13:53:07'),
(8, 'New FAQ added: azsasas', 'unread', '2024-12-02 14:02:21'),
(9, 'New FAQ added: aaaaaaaaaaaaa', 'unread', '2024-12-02 14:02:25'),
(10, 'New FAQ added: ssssssssssssssssssssssss', 'unread', '2024-12-02 14:02:31'),
(11, 'FAQ updated: sasasas', 'unread', '2024-12-02 14:02:35'),
(12, 'New FAQ added: sasas', 'unread', '2024-12-02 14:02:51'),
(13, 'FAQ deleted: azsasas', 'unread', '2024-12-02 14:02:56'),
(14, 'FAQ deleted: aaaaaaaaaaaaa', 'unread', '2024-12-02 14:02:58'),
(15, 'FAQ deleted: sasasas', 'unread', '2024-12-02 14:03:00'),
(16, 'FAQ deleted: sasas', 'unread', '2024-12-02 14:03:01'),
(17, 'New FAQ added: aaaaaaaaaaaaa', 'unread', '2024-12-02 14:10:44'),
(18, 'New FAQ added: aaaaaa', 'unread', '2024-12-02 14:11:08'),
(19, 'FAQ deleted: aaaaaaaaaaaaa', 'unread', '2024-12-02 14:16:21'),
(20, 'FAQ deleted: aaaaaa', 'unread', '2024-12-02 14:16:24'),
(21, 'New FAQ added: assssa', 'unread', '2024-12-02 14:16:45'),
(22, 'New FAQ added: aaaaaaaaaaa', 'unread', '2024-12-02 14:21:15'),
(23, 'FAQ deleted: assssa', 'unread', '2024-12-02 14:21:33'),
(24, 'FAQ deleted: aaaaaaaaaaa', 'unread', '2024-12-02 14:21:35'),
(25, 'New FAQ added: ggg', 'unread', '2024-12-02 14:37:37'),
(26, 'FAQ deleted: ggg', 'unread', '2024-12-02 14:37:50'),
(27, 'New FAQ added: aaaaaaa', 'unread', '2024-12-02 14:38:19'),
(28, 'FAQ deleted: aaaaaaa', 'unread', '2024-12-02 14:38:33'),
(29, 'New FAQ added: aaaaaaaaaaaaaa', 'unread', '2024-12-02 14:52:10'),
(30, 'New FAQ added: sasa', 'unread', '2024-12-02 14:52:14'),
(31, 'FAQ deleted: aaaaaaaaaaaaaa', 'unread', '2024-12-02 14:52:16'),
(32, 'FAQ deleted: sasa', 'unread', '2024-12-02 14:52:18'),
(33, 'New FAQ added: aaaaaaaaaaaaaa', 'unread', '2024-12-03 12:58:43'),
(34, 'FAQ deleted: aaaaaaaaaaaaaa', 'unread', '2024-12-03 12:58:50'),
(35, 'New FAQ added: assssa', 'unread', '2024-12-03 13:03:16'),
(36, 'FAQ updated: assssasasasas', 'unread', '2024-12-03 13:03:22'),
(37, 'FAQ deleted: assssasasasas', 'unread', '2024-12-03 13:03:25'),
(38, 'New FAQ added: ggg', 'unread', '2024-12-05 03:42:50'),
(39, 'FAQ updated: ggg', 'unread', '2024-12-05 03:42:54'),
(40, 'FAQ deleted: ggg', 'unread', '2024-12-05 03:42:55');

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
  `scholarship_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholars`
--

INSERT INTO `scholars` (`sr_code`, `name`, `course`, `year_level`, `scholarship_id`) VALUES
('21-20930', 'Jose Cruz', 'BSCS', '3rd Year', 9),
('21-34567', 'Ana Dela Cruz', 'BSBA', '4th Year', 16),
('21-89012', 'Maria Santos', 'Medtech', '3rd Year', 14),
('22-90123', 'Karla Garcia', 'BSIT', '1st Year', 4),
('23-09231', 'Sophia Cruz', 'BSCS', '3rd Year', 12),
('23-09233', 'Oliver Reyes', 'BSCS', '3rd year', 8),
('23-09234', 'Emma Santos', 'Medtech', '2nd year', 17),
('23-09236', 'Mia Lopez', 'Engineering', '4th Year', 18),
('23-09237', 'Hannah Cruz', 'BSBA', '1st Year', 11),
('23-09239', 'Ava Santos', 'BSIT', '2nd year', 10),
('23-09240', 'Ethan Garcia', 'Engineering', '3rd Year', 17);

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
(1, 'International Students Grant', 'Helps international students with tuition and living expenses.', '2025-12-31', 'Proof of enrollment, Financial need', '2024-12-06 11:15:41', '2024-12-06 11:15:57', 'Active'),
(2, 'OWWA Scholarships', 'Scholarship for dependents of OFWs provided by OWWA.', '2025-01-10', 'OFW parent, GPA above 2.5, Proof of enrollment', '2024-11-22 04:57:05', '2024-12-06 07:07:47', 'Active'),
(3, 'DOST Scholarship', 'Science and technology scholarship for students with a strong academic record.', '2024-12-20', 'GPA above 3.5, STEM course enrollment', '2024-11-22 04:57:05', '2024-12-06 07:07:51', 'Active'),
(4, 'SM Scholarship', 'A scholarship for financially challenged students with good academic standing.', '2024-11-30', 'GPA above 3.0, Proof of financial need', '2024-11-22 04:57:05', '2024-12-06 07:08:00', 'Active'),
(5, 'Aboitiz Scholarship Program', 'Supports students pursuing careers in engineering and business.', '2025-01-25', 'Engineering or business course, GPA above 3.2, Recommendation letter', '2024-11-22 04:57:05', '2024-12-06 07:07:55', 'Active'),
(6, 'Megaworld Scholarship', 'A scholarship for students in partner schools demonstrating academic excellence.', '2025-02-15', 'GPA above 3.3, Essay on career goals', '2024-11-22 04:57:05', '2024-12-06 07:08:11', 'Active'),
(7, 'Security Bank Scholarship', 'Financial assistance for deserving students in partner schools.', '2024-12-05', 'Partner school enrollment, GPA above 3.0, Financial need proof', '2024-11-22 04:57:05', '2024-12-06 08:00:34', 'Active'),
(8, 'CHED Medical Scholarship', 'Scholarship for medical students under the CHED program.', '2024-12-31', 'Medical school enrollment, GPA above 3.2', '2024-11-22 04:57:05', '2024-12-06 08:00:37', 'Active'),
(9, 'DOH Pre-Service Scholarship', 'A pre-service scholarship for healthcare students under DOH.', '2024-11-10', 'Healthcare field enrollment, GPA above 3.0, Service agreement', '2024-11-22 04:57:05', '2024-12-06 08:00:41', 'Active'),
(10, 'Ayala Foundation Scholarship', 'Scholarship for students with strong academic and leadership skills.', '2025-03-01', 'Leadership experience, GPA above 3.4, Essay on community impact', '2024-11-22 04:57:05', '2024-12-06 08:00:46', 'Active'),
(11, 'Hawak Kamay Scholarship', 'Support for students in financial need who show academic promise.', '2024-10-30', 'GPA above 2.8, Proof of financial need', '2024-11-22 04:57:05', '2024-12-06 08:00:55', 'Active'),
(12, 'CHED Tulong Dunong Scholarship', 'Financial assistance program for eligible college students.', '2025-01-05', 'GPA above 2.5, Income proof, Recommendation letter', '2024-11-22 04:57:05', '2024-12-06 08:00:58', 'Active'),
(13, 'Iskolar ni Juan', 'Scholarship for students in public colleges with good academic standing.', '2025-02-20', 'Public school enrollment, GPA above 3.0', '2024-11-22 04:57:05', '2024-12-06 08:00:51', 'Active'),
(14, 'Landbank Scholarship', 'Scholarship for students in agriculture or related fields.', '2024-12-15', 'Agriculture-related course, GPA above 3.0, Service agreement', '2024-11-22 04:57:05', '2024-12-06 08:01:05', 'Active'),
(15, 'PHINMA Scholarship', 'Scholarship for students in PHINMA partner schools with financial need.', '2025-01-15', 'PHINMA school enrollment, Financial need, Essay', '2024-11-22 04:57:05', '2024-12-06 08:01:14', 'Active'),
(16, 'CHED CoScho Scholarship', 'Co-sponsored scholarship under CHED for deserving students.', '2025-03-10', 'GPA above 3.2, Sponsorship agreement', '2024-11-22 04:57:05', '2024-12-06 08:00:29', 'Active'),
(17, 'Merit Scholarship', 'For academically excellent students', '2024-12-31', 'GWA of 1.75 or higher', '2024-11-30 13:59:13', '2024-12-06 08:00:25', 'Active'),
(18, 'Athletic Scholarship', 'For student athletes', '2024-12-31', 'Member of varsity team', '2024-11-30 13:59:13', '2024-12-06 08:00:20', 'Active'),
(19, 'Financial Aid', 'For financially challenged students', '2024-12-31', 'Income certificate requireds', '2024-11-30 13:59:13', '2024-12-06 07:07:37', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_pie_chart`
--

CREATE TABLE `scholarship_pie_chart` (
  `id` int(11) NOT NULL,
  `scholarship_program` varchar(100) NOT NULL,
  `scholar_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_pie_chart`
--

INSERT INTO `scholarship_pie_chart` (`id`, `scholarship_program`, `scholar_count`) VALUES
(1, 'CHED', 10),
(2, 'OWWA', 8),
(3, 'DOST', 5);

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_request`
--

CREATE TABLE `scholarship_request` (
  `scholarship_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `scholarship` varchar(255) DEFAULT NULL,
  `student_no` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `year_level` varchar(50) DEFAULT NULL,
  `status` enum('pending','approved','disapproved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Academic Excellence', '1st Year BSU-Lipa', '2024-2025', 'Merit-based', 'Applicants must have an overall average of 90% or above in their most recent academic year or term.', '2024-11-15', 'Birth Certificate, Report Card, Enrollment Form', 'Rewards outstanding students who consistently achieve high grades', 3000.00, 'Open', '2024-03-28'),
(2, 'DOST', '2nd Year/ BSU-Lipa', '2024-2025', 'Need-based', 'Nothinga', '2024-12-25', 'Nothing', 'Nothing', 65000.00, 'Open', '2024-12-05');

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
(9, '2023-2024', '1st', 'Inactive', '2024-12-04 14:19:26'),
(10, '2023-2024', 'Summer', 'Active', '2024-12-05 06:21:05'),
(12, '2023-2025', 'Summer', 'Inactive', '2024-12-05 11:31:05'),
(13, '2023-2025', '1st', 'Inactive', '2024-12-05 11:51:40'),
(15, '2021-2024', '1st', 'Inactive', '2024-12-06 13:55:23'),
(16, '2023-2024', '2nd', 'Active', '2024-12-06 14:01:11'),
(17, '2022-2024', 'Summer', 'Inactive', '2024-12-06 14:04:18'),
(18, '2023-2025', '1st', 'Inactive', '2024-12-06 14:20:43'),
(19, '2021-2024', '1st', 'Inactive', '2024-12-06 14:24:16'),
(20, '2021-2024', '1st', 'Inactive', '2024-12-06 14:43:36'),
(21, '2019-2020', '1st', 'Inactive', '2024-12-06 14:58:41'),
(22, '2020-2020', 'Summer', 'Active', '2024-12-06 15:09:32'),
(23, '2020-2021', '2nd', 'Active', '2024-12-06 15:09:43'),
(24, '2020-2020', '1st', 'Active', '2024-12-06 15:11:22'),
(25, '2023-2024', '1st', 'Inactive', '2024-12-06 15:15:02'),
(26, '2021-2022', '1st', 'Inactive', '2024-12-06 15:17:16');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sr_code` varchar(20) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `sr_code`, `mobile_number`, `password`) VALUES
(1, 'Jose Cruz', 'jose.cruz@g.batstate-u.edu.ph', '21-20930', '09123456789', '21-20930'),
(2, 'Maria Santos', 'maria.santos@g.batstate-u.edu.ph', '21-89012', '09123456780', '21-89012'),
(3, 'Mark Bautista', 'mark.bautista@g.batstate-u.edu.ph', '21-23456', '09123456781', '21-23456'),
(4, 'Ana Dela Cruz', 'ana.delacruz@g.batstate-u.edu.ph', '21-34567', '09123456782', '21-34567'),
(5, 'Carla Ramirez', 'carla.ramirez@g.batstate-u.edu.ph', '22-45678', '09123456783', '22-45678'),
(6, 'Miguel Reyes', 'miguel.reyes@g.batstate-u.edu.ph', '21-56789', '09123456784', '21-56789'),
(7, 'Isabel Flores', 'isabel.flores@g.batstate-u.edu.ph', '21-67890', '09123456785', '21-67890'),
(8, 'Paolo Garcia', 'paolo.garcia@g.batstate-u.edu.ph', '21-78901', '09123456786', '21-78901'),
(10, 'Juan Dela Cruz', 'juan.delacruz@g.batstate-u.edu.ph', '21-90123', '09123456788', '21-90123'),
(11, 'Carlos Santos', 'carlos.santos@g.batstate-u.edu.ph', '21-01234', '09123456789', '21-01234'),
(12, 'Julia Roldan', 'julia.roldan@g.batstate-u.edu.ph', '22-12345', '09123456790', '22-12345'),
(15, 'Eric Mendoza', 'eric.mendoza@g.batstate-u.edu.ph', '21-45678', '09123456793', '21-45678'),
(20, 'Karla Garcia', 'karla.garcia@g.batstate-u.edu.ph', '22-90123', '09123456798', '22-90123'),
(22, 'Roselle Bautista', 'roselle.bautista@g.batstate-u.edu.ph', '21-12345', '09123456800', '21-12345'),
(24, 'Angela Marquez', 'angela.marquez@g.batstate-u.edu.ph', '22-34567', '09123456802', '22-34567'),
(29, 'Sandra Diaz', 'sandra.diaz@g.batstate-u.edu.ph', '22-89012', '09123456807', '22-89012'),
(32, 'Sophia Cruz', 'sophia.cruz@g.batstate-u.edu.ph', '23-09231', '09123456810', '23-09231'),
(33, 'Liam Garcia', 'liam.garcia@g.batstate-u.edu.ph', '23-09232', '09123456811', '23-09232'),
(34, 'Oliver Reyes', 'oliver.reyes@g.batstate-u.edu.ph', '23-09233', '09123456812', '23-09233'),
(35, 'Emma Santos', 'emma.santos@g.batstate-u.edu.ph', '23-09234', '09123456813', '23-09234'),
(36, 'Lucas Fernandez', 'lucas.fernandez@g.batstate-u.edu.ph', '23-09235', '09123456814', '23-09235'),
(37, 'Mia Lopez', 'mia.lopez@g.batstate-u.edu.ph', '23-09236', '09123456815', '23-09236'),
(38, 'Hannah Cruz', 'hannah.cruz@g.batstate-u.edu.ph', '23-09237', '09123456816', '23-09237'),
(39, 'Noah Bautista', 'noah.bautista@g.batstate-u.edu.ph', '23-09238', '09123456817', '23-09238'),
(40, 'Ava Santos', 'ava.santos@g.batstate-u.edu.ph', '23-09239', '09123456818', '23-09239'),
(41, 'Ethan Garcia', 'ethan.garcia@g.batstate-u.edu.ph', '23-09240', '09123456819', '23-09240'),
(42, 'Isabella Reyes', 'isabella.reyes@g.batstate-u.edu.ph', '23-09241', '09123456820', '23-09241'),
(43, 'Jacob Ramirez', 'jacob.ramirez@g.batstate-u.edu.ph', '23-09242', '09123456821', '23-09242'),
(44, 'Sophia Castillo', 'sophia.castillo@g.batstate-u.edu.ph', '23-09243', '09123456822', '23-09243'),
(45, 'Mason Tan', 'mason.tan@g.batstate-u.edu.ph', '23-09244', '09123456823', '23-09244'),
(46, 'Charlotte Lopez', 'charlotte.lopez@g.batstate-u.edu.ph', '23-09245', '09123456824', '23-09245'),
(47, 'Logan Mendoza', 'logan.mendoza@g.batstate-u.edu.ph', '23-09246', '09123456825', '23-09246'),
(48, 'Amelia Fernandez', 'amelia.fernandez@g.batstate-u.edu.ph', '23-09247', '09123456826', '23-09247'),
(49, 'Benjamin Ortiz', 'benjamin.ortiz@g.batstate-u.edu.ph', '23-09248', '09123456827', '23-09248'),
(50, 'Ella Marquez', 'ella.marquez@g.batstate-u.edu.ph', '23-09249', '09123456828', '23-09249'),
(51, 'Joan Briones', '23-36298@g.batstate-u.edu.ph', '23-36298', '09668744635', '23-36298'),
(52, 'justin katigbak', '23-37298@g.batstate-u.edu.ph', '23-37298', '09998744635', '23-37298'),
(53, 'MARIA BRIONES', '23-36398@g.batstate-u.edu.ph', '23-36398', '09798744635', '23-36398'),
(54, 'Jose Katigbak', '23-37398@g.batstate-u.edu.ph', '23-37398', '09798744635', '23-37398'),
(55, 'Joan Briones', 'qti@g.batstate-u.edu.ph', '23-36299', '09778744635', '23-36299'),
(56, 'Ariana Grande', 'ariana@g.batstate-u.edu.ph', '23-36291', '09977325864', '23-36291'),
(57, 'Anne Trisha', 'trishamarzo@g.batstate-u.edu.ph', '23-36297', '09977325865', '23-36297'),
(58, 'jezrev labay', 'jezrev@g.batstate-u.edu.ph', '20-34567', '09654167419', '20-34567'),
(59, 'Jayden Mark', 'briones@g.batstate-u.edu.ph', '21-39899', '09363363611', '21-39899'),
(60, 'Justin Kyle Katigbak', 'justin.kyle@g.batstate-u.edu.ph', '23-36278', '09223363611', '23-36278'),
(61, 'Johnver Briones', 'johnverbriones@g.batstate-u.edu.ph', '20-20222', '0977238546', '20-20222'),
(62, 'Sky Belle', 'skybelle@g.batstate-u.edu.ph', '21-21234', '09112232322', '21-21234'),
(64, 'Sarah Santos', 'sarahs@g.batstate-u.edu.ph', '22-89018', '09123486780', '22-89018'),
(65, 'Joan Katigbak', 'joankatigbak@g.batstate-u.edu.ph', '21-23232', '09787787811', '21-23232'),
(66, 'Joed Katigbak', 'joedkatigbak@g.batstate-u.edu.ph', '23-23232', '09887787811', '23-23232');

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
  `student_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `student_id`, `login_time`, `logout_time`, `duration`) VALUES
(1, 1, '2024-12-07 00:19:46', '2024-12-07 00:26:31', 405),
(3, 2, '2024-12-06 17:39:18', '2024-12-06 17:39:23', 5),
(8, 61, '2024-12-07 02:09:29', '2024-12-07 02:21:39', 730),
(10, 1, '2024-12-06 19:23:20', '2024-12-06 19:23:25', 5),
(17, 2, '2024-12-06 19:28:49', '2024-12-06 19:28:54', 5);

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
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `featured_scholars`
--
ALTER TABLE `featured_scholars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sr_code` (`sr_code`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
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
  ADD PRIMARY KEY (`sr_code`),
  ADD KEY `scholarship_id` (`scholarship_id`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`scholarship_id`);

--
-- Indexes for table `scholarship_pie_chart`
--
ALTER TABLE `scholarship_pie_chart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scholarship_request`
--
ALTER TABLE `scholarship_request`
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
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `sr_code` (`sr_code`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

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
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `featured_scholars`
--
ALTER TABLE `featured_scholars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reviewers`
--
ALTER TABLE `reviewers`
  MODIFY `reviewer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `scholarship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `scholarship_pie_chart`
--
ALTER TABLE `scholarship_pie_chart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scholarship_request`
--
ALTER TABLE `scholarship_request`
  MODIFY `scholarship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `schema_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_application`
--
ALTER TABLE `user_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- Constraints for table `featured_scholars`
--
ALTER TABLE `featured_scholars`
  ADD CONSTRAINT `featured_scholars_ibfk_1` FOREIGN KEY (`sr_code`) REFERENCES `scholars` (`sr_code`) ON DELETE CASCADE;

--
-- Constraints for table `scholars`
--
ALTER TABLE `scholars`
  ADD CONSTRAINT `scholars_ibfk_1` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`scholarship_id`);

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
-- Constraints for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
