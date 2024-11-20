<?php 

if (isset($_POST["submit"])) {
    
    // Get Data
    $email = $_POST["email"];
    $Sr_code = $_POST["Sr_code"]; 
    $password = $_POST["password"];

    include "../dbh.classes.php";
    include "../classes/login.classes.php";
    include "../classes/login_contr.class.php";

    // Instantiate 
    $login = new LoginContr($email, $Sr_code, $password);

    // Run Error Handlers and Login
    $login->loginStudent();

    header("location: ../usersignup.html?error=none");
    exit();
} else {
    header("location: ../index.php");
    exit();
}

?>
