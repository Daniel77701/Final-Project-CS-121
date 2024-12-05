<?php
session_start();

require_once '../classes/dbh.classes.php';
require_once '../classes/scholarship-request.classes.php';

$scholarshipRequest = new ScholarshipRequest();

// Handle form submission for adding/editing students
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['save_request'])) {
            $type = $_POST['type'];
            $scholarship = $_POST['scholarship'];
            $student_no = $_POST['student_no'];
            $name = $_POST['name'];
            $course = $_POST['course'];
            $year_level = $_POST['year_level'];
            $status = $_POST['status'] ?: 'pending';

            if ($scholarshipRequest->addRequest($type, $scholarship, $student_no, $name, $course, $year_level, $status)) {
                $_SESSION['success_message'] = "Student added successfully!";
            }
            header("Location: scholarship-request.php");
            exit();
        }

        if (isset($_POST['delete_request'])) {
            $id = $_POST['id'];
            
            if ($scholarshipRequest->deleteRequest($id)) {
                $_SESSION['success_message'] = "Request deleted successfully!";
            }
            header("Location: scholarship-request.php");
            exit();
        }

        if (isset($_POST['edit_request'])) {
            $id = $_POST['requestId'];
            $type = $_POST['type'];
            $scholarship = $_POST['scholarship'];
            $student_no = $_POST['student_no'];
            $name = $_POST['name'];
            $course = $_POST['course'];
            $year_level = $_POST['year_level'];
            $status = $_POST['status'] ?: 'pending';

            if ($scholarshipRequest->updateRequest($id, $type, $scholarship, $student_no, $name, $course, $year_level, $status)) {
                $_SESSION['success_message'] = "Request updated successfully!";
            }
            header("Location: scholarship-request.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "An error occurred: " . $e->getMessage();
        header("Location: scholarship-request.php");
        exit();
    }
}

// Function to get all requests (used by the main page)
function getAllRequests() {
    global $scholarshipRequest;
    return $scholarshipRequest->getAllRequests();
}

// Function to get user scholarship status
function getUserScholarshipStatus($student_no) {
    global $scholarshipRequest;
    return $scholarshipRequest->getUserScholarshipStatus($student_no);
} 