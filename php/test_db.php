<?php
include "database.php";

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "Database connection successful!<br>";
    
    $result = $conn->query("SHOW TABLES");
    echo "<h3>Tables in database:</h3>";
    while ($row = $result->fetch_array()) {
        echo $row[0] . "<br>";
    }
    
    $result = $conn->query("DESCRIBE students");
    echo "<h3>Structure of students table:</h3>";
    while ($row = $result->fetch_array()) {
        echo $row['Field'] . " - " . $row['Type'] . "<br>";
    }
} else {
    echo "Database connection failed!";
} 