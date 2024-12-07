<?php
$servername = "localhost";
$username = "root";  // Your database username
$password = "";      // Your database password
$dbname = "db_scholarshiptracker";  // Corrected database name

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $e->getMessage()]);
    die();
}
?> 