<?php
require_once 'config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectDB();
    
    // Sanitize inputs
    $scholarship_id = sanitize($_POST['scholarship_id']);
    $user_id = $_SESSION['user_id'];
    
    // Generate unique application number
    $application_number = 'APP' . date('Y') . rand(1000, 9999);
    
    // Handle file upload
    $uploaded_files = [];
    if (isset($_FILES['documents'])) {
        $target_dir = "uploads/";
        foreach ($_FILES['documents']['name'] as $key => $name) {
            $target_file = $target_dir . time() . '_' . basename($name);
            if (move_uploaded_file($_FILES['documents']['tmp_name'][$key], $target_file)) {
                $uploaded_files[] = $target_file;
            }
        }
    }
    
    // Insert application
    $documents = json_encode($uploaded_files);
    $stmt = $conn->prepare("INSERT INTO applications (user_id, scholarship_id, application_number, documents_submitted) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $scholarship_id, $application_number, $documents);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Application submitted successfully!";
        header("Location: application_history.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error submitting application. Please try again.";
        header("Location: apply.php");
        exit();
    }
    
    $stmt->close();
    $conn->close();
}
?>