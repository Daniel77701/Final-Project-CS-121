<?php

require_once '../connection/dbh.classes.php';

class AnnouncementHandler extends Dbh {
    // Fetch all announcements
    public function getAnnouncements() {
        try {
            $sql = "SELECT * FROM announcements ORDER BY date_posted DESC";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAnnouncements: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }

    // Add a new announcement
    public function addAnnouncement($subject, $announcement) {
        try {
            $sql = "INSERT INTO announcements (subject, announcement) VALUES (?, ?)";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$subject, $announcement])) {
                throw new Exception("Failed to add announcement");
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error in addAnnouncement: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }

    // Edit an announcement
    public function editAnnouncement($id, $subject, $announcement) {
        try {
            $sql = "UPDATE announcements SET subject = ?, announcement = ? WHERE id = ?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$subject, $announcement, $id])) {
                throw new Exception("Failed to update announcement");
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error in editAnnouncement: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }

    // Delete an announcement
    public function deleteAnnouncement($id) {
        try {
            $sql = "DELETE FROM announcements WHERE id = ?";
            $stmt = $this->connect()->prepare($sql);
            if (!$stmt->execute([$id])) {
                throw new Exception("Failed to delete announcement");
            }
            return true;
        } catch (PDOException $e) {
            error_log("Error in deleteAnnouncement: " . $e->getMessage());
            throw new Exception("Database error occurred");
        }
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    try {
        $handler = new AnnouncementHandler();
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'get_announcements':
                echo json_encode($handler->getAnnouncements());
                break;

            case 'add_announcement':
                $subject = $_POST['subject'] ?? '';
                $announcement = $_POST['announcement'] ?? '';
                if (empty($subject) || empty($announcement)) {
                    throw new Exception("All fields are required");
                }
                $handler->addAnnouncement($subject, $announcement);
                echo json_encode(['success' => true, 'message' => 'Announcement added successfully']);
                break;

            case 'edit_announcement':
                $id = $_POST['id'] ?? '';
                $subject = $_POST['subject'] ?? '';
                $announcement = $_POST['announcement'] ?? '';
                if (empty($id) || empty($subject) || empty($announcement)) {
                    throw new Exception("All fields are required");
                }
                $handler->editAnnouncement($id, $subject, $announcement);
                echo json_encode(['success' => true, 'message' => 'Announcement updated successfully']);
                break;

            case 'delete_announcement':
                $id = $_POST['id'] ?? '';
                if (empty($id)) {
                    throw new Exception("ID is required");
                }
                $handler->deleteAnnouncement($id);
                echo json_encode(['success' => true, 'message' => 'Announcement deleted successfully']);
                break;

            default:
                throw new Exception("Invalid action");
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
