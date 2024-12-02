<?php
require_once "../dbh.classes.php";

try {
    // Get scholars count
    $scholarsSql = "SELECT COUNT(*) AS total FROM scholars";
    $scholarsStmt = (new Dbh())->connect()->prepare($scholarsSql);
    $scholarsStmt->execute();
    $scholarsCount = $scholarsStmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Get scholarships count
    $scholarshipsSql = "SELECT COUNT(*) AS total FROM scholarships";
    $scholarshipsStmt = (new Dbh())->connect()->prepare($scholarshipsSql);
    $scholarshipsStmt->execute();
    $scholarshipsCount = $scholarshipsStmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Get announcements count
    $announcementsSql = "SELECT COUNT(*) AS total FROM announcements";
    $announcementsStmt = (new Dbh())->connect()->prepare($announcementsSql);
    $announcementsStmt->execute();
    $announcementsCount = $announcementsStmt->fetch(PDO::FETCH_ASSOC)['total'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
