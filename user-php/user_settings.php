<?php
session_start();
if (!isset($_SESSION["user_name"])) {
    header("Location: user_login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="icons/logo.png" type="image/x-icon">
    <title>Settings - Scholarship Tracker System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="new_style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
</body>
</html> 