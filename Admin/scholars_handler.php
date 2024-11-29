<?php
include_once "../dbh.classes.php";

class Scholars {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Dbh())->connect();
    }

    // Add a new scholar to the database
    public function addScholar($sr_code, $name, $course, $year_level, $scholarship) {
        $sql = "INSERT INTO scholars (sr_code, name, course, year_level, scholarship) VALUES (:sr_code, :name, :course, :year_level, :scholarship)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':sr_code' => $sr_code,
            ':name' => $name,
            ':course' => $course,
            ':year_level' => $year_level,
            ':scholarship' => $scholarship
        ]);
    }

    // Fetch all scholars from the database
    public function getScholars() {
        $sql = "SELECT * FROM scholars";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Delete a scholar by SR Code
    public function deleteScholar($sr_code) {
        $sql = "DELETE FROM scholars WHERE sr_code = :sr_code";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':sr_code' => $sr_code]);
    }

    // Update a scholar's details
    public function updateScholar($sr_code, $name, $course, $year_level, $scholarship) {
        $sql = "UPDATE scholars SET name = :name, course = :course, year_level = :year_level, scholarship = :scholarship WHERE sr_code = :sr_code";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':sr_code' => $sr_code,
            ':name' => $name,
            ':course' => $course,
            ':year_level' => $year_level,
            ':scholarship' => $scholarship
        ]);
    }
}

// Handle form submission for adding a scholar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_scholar'])) {
    $sr_code = $_POST['sr_code'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];
    $scholarship = $_POST['scholarship'];

    // Add the new scholar
    $scholars = new Scholars();
    $scholars->addScholar($sr_code, $name, $course, $year_level, $scholarship);
    header("Location: scholars.php");
}

// Handle scholar deletion
if (isset($_GET['delete_sr_code'])) {
    $sr_code = $_GET['delete_sr_code'];
    $scholars = new Scholars();
    $scholars->deleteScholar($sr_code);
    header("Location: scholars.php");
}

// Handle scholar update
if (isset($_POST['update_scholar'])) {
    $sr_code = $_POST['sr_code'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];
    $scholarship = $_POST['scholarship'];

    // Update the scholar
    $scholars = new Scholars();
    $scholars->updateScholar($sr_code, $name, $course, $year_level, $scholarship);
    header("Location: scholars.php");
}
?>
