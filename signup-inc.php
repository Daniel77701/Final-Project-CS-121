<?php 

if (isset($_POST["submit"])) {
    
    // Get Data
    $Name = $_POST["Name"];
    $email = $_POST["email"];
    $Sr_code = $_POST["Sr-code"];
    $Mobilenum = $_POST["Mobile Number"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["confirm_password"];

    // Instantiate
    include "../classes/signup.classes.php";
    include "../classes/signup_contr.class.php";
    $signup = new SignupContr($Name, $email, $Sr_code, $Mobilenum, $password, $passwordRepeat);
}
