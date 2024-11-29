<?php
include("../dbh.classes.php");

$dbh = new Dbh();
$conn = $dbh->connect();

$sql = "SELECT scholarship, message, name, course, email, created_at FROM feedbacks ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$feedbacks = $stmt->fetchAll();

$conn = null;
?>
