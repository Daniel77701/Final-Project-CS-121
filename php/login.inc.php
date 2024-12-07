<?php
error_log("Login process started");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("POST data received: " . print_r($_POST, true));
    
    $login_id = $_POST["login_id"] ?? '';
    $pwd = $_POST["pwd"] ?? '';

    if (empty($login_id) || empty($pwd)) {
        error_log("Empty credentials");
        header("location: ../html/user_login.html?error=empty");
        exit();
    }

    require_once "../classes/login.contr.php";
    $login = new LoginContr($login_id, $pwd);
    
    try {
        $login->loginUser();
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        header("location: ../html/user_login.html?error=failed");
        exit();
    }
} else {
    header("location: ../html/user_login.html");
    exit();
} 