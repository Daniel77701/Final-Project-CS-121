<?php
class Profile extends Database {
    private $userId;

    public function __construct($userId) {
        parent::__construct(); 
        $this->userId = $userId;
    }

    public function getProfileDetails() {
        $query = "SELECT fullName, contactNumber, username, registrationDate, email FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->userId);

        if (!$stmt->execute()) {
            throw new Exception("Error fetching profile: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $profile = $result->fetch_assoc();
        $stmt->close();

        return $profile;
    }

    public function updateProfile($data) {
        if (empty($data['fullName']) || empty($data['email']) || empty($data['contactNumber'])) {
            throw new Exception("All fields are required.");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        $query = "UPDATE users SET fullName = ?, contactNumber = ?, username = ?, registrationDate = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Query preparation failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssssi",
            $data['fullName'],
            $data['contactNumber'],
            $data['username'],
            $data['registrationDate'],
            $data['email'],
            $this->userId
        );

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}

$userId = 1; 
$profile = new Profile($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = [
            'fullName' => $_POST['fullName'],
            'contactNumber' => $_POST['contactNumber'],
            'username' => $_POST['username'],
            'registrationDate' => $_POST['registrationDate'],
            'email' => $_POST['email']
        ];

        if ($profile->updateProfile($data)) {
            $successMessage = "Profile updated successfully!";
        }
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

try {
    $updatedProfile = $profile->getProfileDetails();
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}