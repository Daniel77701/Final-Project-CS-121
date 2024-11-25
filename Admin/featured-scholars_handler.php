<?php

$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$dbname = 'db_scholarshiptracker'; 

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'fetch':
            fetchScholars($conn);
            break;

        case 'add':
            addScholar($conn);
            break;

        case 'delete':
            deleteScholar($conn);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
}

function fetchScholars($conn) {
    $sql = "SELECT * FROM featured_scholars";  
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $scholars = [];
        while ($row = $result->fetch_assoc()) {
            $scholars[] = $row;
        }
        echo json_encode($scholars);
    } else {
        echo json_encode([]);
    }
}

function addScholar($conn) {
    if (
        isset($_POST['subject']) && isset($_POST['course']) && 
        isset($_POST['year_graduated']) && isset($_POST['message']) && 
        isset($_POST['status'])
    ) {
        $subject = $conn->real_escape_string($_POST['subject']);
        $course = $conn->real_escape_string($_POST['course']);
        $year_graduated = $conn->real_escape_string($_POST['year_graduated']);
        $message = $conn->real_escape_string($_POST['message']);
        $status = $conn->real_escape_string($_POST['status']);

        $sql = "INSERT INTO featured_scholars (subject, course, year_graduated, message, status) 
                VALUES ('$subject', '$course', '$year_graduated', '$message', '$status')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Scholar added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error adding scholar: ' . $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    }
}

function deleteScholar($conn) {
    if (isset($_POST['id'])) {
        $id = (int)$_POST['id'];

        $sql = "DELETE FROM featured_scholars WHERE id = $id";  

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Scholar deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error deleting scholar: ' . $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing scholar ID']);
    }
}

$conn->close();
?>
