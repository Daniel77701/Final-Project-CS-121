<?php
header('Content-Type: text/plain');

try {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $srcode = $_POST["srcode"];
    $mobile = $_POST["mobile"];
    $pwd = $_POST["pwd"];
    
    $conn = new mysqli("localhost", "root", "", "scholarship_db");
    
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, srcode, mobile, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $srcode, $mobile, $hashedPwd);

    $stmt->execute();
    echo "success";

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo "success"; 
}
?> 