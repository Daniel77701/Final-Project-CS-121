<?php
session_start();
require_once 'config/db.php';

// Check if user is admin
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != true) {
    header("Location: index.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    
    // Get the scholarship details from the database
    $sql_get_details = "SELECT type, scholarship, name FROM scholarship_request WHERE scholarship_id = ?";
    $stmt_details = $conn->prepare($sql_get_details);
    $stmt_details->bind_param("i", $request_id);
    $stmt_details->execute();
    $result = $stmt_details->get_result();
    $details = $result->fetch_assoc();
    
    // Update the status in database
    $sql = "UPDATE scholarship_request SET status = ? WHERE scholarship_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $request_id);
    
    if($stmt->execute()) {
        // Create message based on status
        switch($status) {
            case 'Approved':
                $_SESSION['message'] = '<div class="card bg-success text-white">
                    <h2 class="card-title">Scholarship Approval</h2>
                    <p>Congratulations ' . htmlspecialchars($details['name']) . '!</p>
                    <p>You have been approved for the ' . htmlspecialchars($details['scholarship']) . ' (' . htmlspecialchars($details['type']) . ') scholarship.</p>
                    <p>Please check your email for further instructions.</p>
                </div>';
                break;
                
            case 'Not Approved':
                $_SESSION['message'] = '<div class="card bg-danger text-white">
                    <h2 class="card-title">Scholarship Application Status</h2>
                    <p>Dear ' . htmlspecialchars($details['name']) . ',</p>
                    <p>We regret to inform you that your application for the ' . htmlspecialchars($details['scholarship']) . ' (' . htmlspecialchars($details['type']) . ') scholarship was not approved.</p>
                    <p>Please contact the scholarship office for more information.</p>
                </div>';
                break;
                
            case 'Pending':
                $_SESSION['message'] = '<div class="card bg-warning">
                    <h2 class="card-title">Application Under Review</h2>
                    <p>Dear ' . htmlspecialchars($details['name']) . ',</p>
                    <p>Your application for the ' . htmlspecialchars($details['scholarship']) . ' (' . htmlspecialchars($details['type']) . ') scholarship is currently under review.</p>
                    <p>Please check back later for updates.</p>
                </div>';
                break;
        }
        
        header("Location: scholarship-request.php?success=1");
    } else {
        header("Location: scholarship-request.php?error=1");
    }
    exit();
} 