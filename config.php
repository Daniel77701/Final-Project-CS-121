<?php
// Database configuration
$host = "localhost";
$username = "root";  // Your MySQL username
$password = "";      // Your MySQL password
$database = "db_scholarshiptracker";

// Create mysqli connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check mysqli connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8mb4
mysqli_set_charset($conn, "utf8mb4");

// Also create PDO connection for files that use PDO
try {
    $dsn = "mysql:host=" . $host . ";dbname=" . $database;
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("PDO Connection failed: " . $e->getMessage());
}

// Define constants for dbh.classes.php
define('DB_HOST', $host);
define('DB_USER', $username);
define('DB_PASS', $password);
define('DB_NAME', $database);
?> 