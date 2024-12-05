<?php

require_once '../connection/dbh.classes.php';

class AnnouncementHandler extends Dbh {
    // Fetch all announcements
    public function getAnnouncements() {
        try {
            $sql = "SELECT id, subject, announcement, date_posted FROM announcements ORDER BY date_posted DESC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Add a new announcement
    public function addAnnouncement($subject, $announcement) {
        try {
            $sql = "INSERT INTO announcements (subject, announcement, date_posted) VALUES (:subject, :announcement, NOW())";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':announcement', $announcement);
            $stmt->execute();
            return "Announcement added successfully!";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Edit an existing announcement
    public function editAnnouncement($id, $subject, $announcement) {
        try {
            $sql = "UPDATE announcements SET subject = :subject, announcement = :announcement WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':announcement', $announcement);
            $stmt->execute();
            return "Announcement updated successfully!";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Delete an announcement
    public function deleteAnnouncement($id) {
        try {
            $sql = "DELETE FROM announcements WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return "Announcement deleted successfully!";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $handler = new AnnouncementHandler();

    // Check for the action parameter
    $action = $_POST['action'] ?? '';

    if ($action === 'get_announcements') {
        // Fetch and return all announcements
        $announcements = $handler->getAnnouncements();
        echo json_encode($announcements);

    } elseif ($action === 'add_announcement') {
        // Add a new announcement
        $subject = $_POST['subject'] ?? '';
        $announcement = $_POST['announcement'] ?? '';
        if (!empty($subject) && !empty($announcement)) {
            $message = $handler->addAnnouncement($subject, $announcement);
            echo json_encode(['message' => $message]);
        } else {
            echo json_encode(['message' => 'All fields are required!']);
        }

    } elseif ($action === 'edit_announcement') {
        // Edit an existing announcement
        $id = $_POST['id'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $announcement = $_POST['announcement'] ?? '';
        if (!empty($id) && !empty($subject) && !empty($announcement)) {
            $message = $handler->editAnnouncement($id, $subject, $announcement);
            echo json_encode(['message' => $message]);
        } else {
            echo json_encode(['message' => 'All fields are required!']);
        }

    } elseif ($action === 'delete_announcement') {
        // Delete an announcement
        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            $message = $handler->deleteAnnouncement($id);
            echo json_encode(['message' => $message]);
        } else {
            echo json_encode(['message' => 'ID is required for deletion!']);
        }

    } else {
        echo json_encode(['message' => 'Invalid action.']);
    }
}
?>
