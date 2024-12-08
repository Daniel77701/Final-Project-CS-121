<?php
session_start();
require 'classes/User.php';
require 'classes/Application.php';
require 'classes/Schema.php';
require 'classes/Profile.php';
require 'classes/Settings.php';
require 'classes/Dashboard.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $user = new User($_POST['name'], $_POST['email'], $_POST['sr_code'], $_POST['mobile_number'], $_POST['password']);

    if ($user->save()) {
        echo "User signed up successfully!";
    } else {
        echo "Error during signup. Please try again.";
    }
}

$dashboard = new Dashboard();
if (isset($user)) {
    $dashboard->renderUserDashboard($user);
} else {
    echo "No user available for dashboard rendering.";
}
?>
