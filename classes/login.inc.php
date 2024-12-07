<?php
session_start();

if (isset($_POST["submit"])) {
    $uid = $_POST["uid"];  // This can be either email or sr_code
    $pwd = $_POST["pwd"];

    include "../classes/login_contr.class.php";
    $login = new LoginContr($uid, $pwd);

    try {
        $user = $login->loginUser();
        header("location: ../user_dashboard.html?login=success");
        exit();
    } catch (Exception $e) {
        header("location: ../user_login.html?error=" . $e->getMessage());
        exit();
    }
} else {
    header("location: ../user_login.html");
    exit();
}

?>
