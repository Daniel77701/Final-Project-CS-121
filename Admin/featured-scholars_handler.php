<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_scholarshiptracker";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete_scholar') {
        $scholarId = $_POST['scholar_id'];
        $sql = "DELETE FROM featured_scholars WHERE id = $scholarId";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Scholar deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete scholar']);
        }
    } else {
        $subject = $_POST['subject'];
        $course = $_POST['course'];
        $year_graduated = $_POST['year_graduated'];
        $message = $_POST['message'];
        $status = $_POST['status'];
        
        $sql = "INSERT INTO featured_scholars (subject, course, year_graduated, message, status) VALUES ('$subject', '$course', '$year_graduated', '$message', '$status')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Scholar added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add scholar']);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM featured_scholars";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $scholars = [];
        while ($row = $result->fetch_assoc()) {
            $scholars[] = $row;
        }
        echo json_encode(['status' => 'success', 'scholar_data' => $scholars]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No scholars found']);
    }
}

$conn->close();
?>
