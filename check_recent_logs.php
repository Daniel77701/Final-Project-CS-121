<?php
require_once 'connection/dbh.classes.php';

try {
    $db = new Dbh();
    $conn = $db->connect();
    
    // Get most recent logs with student info
    $query = "SELECT ul.*, s.name, s.sr_code 
              FROM user_logs ul 
              JOIN students s ON s.id = ul.student_id 
              ORDER BY ul.login_time DESC 
              LIMIT 5";
    
    $stmt = $conn->query($query);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Recent login activity:\n";
    foreach ($logs as $log) {
        echo "\nStudent: " . $log['name'] . " (" . $log['sr_code'] . ")\n";
        echo "Login: " . $log['login_time'] . "\n";
        echo "Logout: " . ($log['logout_time'] ?? 'Still active') . "\n";
        echo "Duration: " . ($log['duration'] ?? 'N/A') . " seconds\n";
        echo "------------------------\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} 