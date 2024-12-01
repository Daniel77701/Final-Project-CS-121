<?php
session_start();
require_once 'notifications.php';

// For testing purposes
$_SESSION['user_id'] = 1;

$notifications = getUnreadNotifications($_SESSION['user_id']);
$unreadCount = count($notifications);

header('Content-Type: application/json');
echo json_encode([
    'notifications' => $notifications,
    'unreadCount' => $unreadCount
]);
?> 