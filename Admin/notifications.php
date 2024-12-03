<?php
require_once "../dbh.classes.php";

class Notifications {
    private $conn;

    // Constructor accepts a PDO connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Fetch all notifications
    public function getNotifications() {
        $query = "SELECT * FROM notifications ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Mark a notification as read
    public function markAsRead($id) {
        $query = "UPDATE notifications SET status = 'read' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Add a new notification
    public function addNotification($message) {
        $query = "INSERT INTO notifications (message, status) VALUES (:message, 'unread')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Handle API Requests
    public function handleRequest() {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'fetch':
                // Fetch notifications
                $notifications = $this->getNotifications();
                header('Content-Type: application/json');
                echo json_encode($notifications);
                break;

            case 'mark':
                $id = $_POST['id'] ?? null;
                if ($id) {
                    // Mark the notification as read
                    $success = $this->markAsRead($id);
                    header('Content-Type: application/json');
                    echo json_encode(['success' => $success]);
                }
                break;

            default:
                echo "Invalid action.";
                break;
        }
    }
}

// Initialize Database Connection and Notifications Manager
$dbh = new Dbh();
$conn = $dbh->connect();
$notifications = new Notifications($conn);

// Handle Request
$notifications->handleRequest();
?>
