<?php
require_once "../dbh.classes.php";

class NotificationManager {
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
        $query = "UPDATE notifications SET is_read = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Handle API Requests
    public function handleRequest() {
        $action = $_GET['action'] ?? null;

        switch ($action) {
            case 'fetch':
                $notifications = $this->getNotifications();
                header('Content-Type: application/json');
                echo json_encode($notifications);
                break;

            case 'mark':
                $id = $_POST['id'] ?? null;
                if ($id) {
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

$action = $_GET['action'] ?? '';

if ($action === 'fetch') {
    // Fetch all notifications from the database
    $query = "SELECT * FROM notifications ORDER BY created_at DESC";
    $result = $db->query($query);
    $notifications = [];
    
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    echo json_encode($notifications);
}

if ($action === 'mark') {
    // Mark notification as read
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;

    if ($id) {
        $query = "UPDATE notifications SET status = 'read' WHERE id = $id";
        $db->query($query);
    }
}

// Initialize Database Connection and Notification Manager
$dbh = new Dbh();
$conn = $dbh->connect();
$notificationManager = new NotificationManager($conn);

// Handle Request
$notificationManager->handleRequest();
?>
