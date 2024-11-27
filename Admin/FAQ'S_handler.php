<?php

// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../dbh.classes.php";

class FAQ extends Dbh {

    // Method to add FAQ to the database
    public function addFAQ($question, $answer) {
        try {
            $sql = "INSERT INTO faqs (question, answer) VALUES (:question, :answer)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':question', $question);
            $stmt->bindParam(':answer', $answer);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error adding FAQ: " . $e->getMessage();
        }
    }

    // Method to fetch all FAQs
    public function getFAQs() {
        try {
            $sql = "SELECT * FROM faqs";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(); 
        } catch (PDOException $e) {
            echo "Error fetching FAQs: " . $e->getMessage();
        }
    }

    // Method to fetch a FAQ by its ID
    public function getFAQById($id) {
        try {
            $sql = "SELECT * FROM faqs WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(); 
        } catch (PDOException $e) {
            echo "Error fetching FAQ by ID: " . $e->getMessage();
        }
    }

    // Method to update FAQ
    public function updateFAQ($id, $question, $answer) {
        try {
            $sql = "UPDATE faqs SET question = :question, answer = :answer WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':question', $question);
            $stmt->bindParam(':answer', $answer);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error updating FAQ: " . $e->getMessage();
        }
    }

    // Method to delete FAQ
    public function deleteFAQ($id) {
        try {
            $sql = "DELETE FROM faqs WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error deleting FAQ: " . $e->getMessage();
        }
    }
}

// Instantiate FAQ object to use methods
$faq = new FAQ();

// Handle Add FAQ (redirects to avoid resubmitting after refresh)
if (isset($_POST['add'])) {
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $faq->addFAQ($question, $answer);
    header("Location: FAQ'S.php"); // Redirect after adding FAQ
    exit();
}

// Handle Delete FAQ
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $faq->deleteFAQ($id);
    header("Location: FAQ'S.php"); // Redirect after deleting FAQ
    exit();
}

// Handle Update FAQ (redirects after updating)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $faq->updateFAQ($id, $question, $answer);
    header("Location: FAQ'S.php"); // Redirect after updating FAQ
    exit();
}

// Get all FAQs
$faqs = $faq->getFAQs();

// Check if there's an edit request
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $faqItem = $faq->getFAQById($id); // Get the FAQ to be edited
}

?>
