<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/plain');
session_start();

if (isset($_POST["submit"])) {
    try {
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];

        include "database.php";
        include "class/login.classes.php";
        include "class/login_contr.class.php";

        $login = new LoginContr($email, $pwd);
        $user = $login->loginUser();
        
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_email"] = $user["email"];
        $_SESSION["user_srcode"] = $user["sr_code"];
        
        echo json_encode([
            'status' => 'success',
            'user' => [
                'name' => $user["name"],
                'email' => $user["email"],
                'srcode' => $user["sr_code"]
            ]
        ]);
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request";
    exit();
} 