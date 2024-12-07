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
    <style>
    .dropdown-menu {
        background: white !important;
        border: 1px solid #eee;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        width: 400px !important;
        min-width: 400px !important;
    }

    .dropdown-header {
        background: white !important;
        color: black !important;
        font-size: 15px;
        padding: 8px 12px;
        border-bottom: 1px solid #eee;
    }

    .dropdown-item {
        color: black !important;
        font-size: 14px;
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa !important;
    }

    .notification-message {
        color: black !important;
        font-size: 14px;
        margin-bottom: 3px;
        line-height: 1.4;
    }

    .text-muted {
        color: #6c757d !important;
        font-size: 12px !important;
    }

    /* Make graduation cap black */
    .fas.fa-graduation-cap {
        color: black !important;
    }

    .dropdown-divider {
        border-color: #eee;
        margin: 0;
    }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
</body>
</html> 