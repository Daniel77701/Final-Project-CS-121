<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/DatabaseConnection.php';
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $application_no = 'APP' . time() . rand(100, 999);

        $photo_path = '';
        if (isset($_FILES['photo'])) {
            $photo_path = 'uploads/photos/' . time() . '_' . $_FILES['photo']['name'];
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
        }

        $stmt = $conn->prepare("INSERT INTO application (
            application_no,
            schema_id,
            scholarship_type,
            photo_path,
            applicant_name,
            date_of_birth,
            gender,
            mobile_number,
            email,
            sr_code,
            year_level,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");

        $scholarship_type = 'Academic Excellence';
        
        $stmt->bind_param("sssssssssss",
            $application_no,
            $_POST['schema_id'],
            $scholarship_type,
            $photo_path,
            $_POST['name'],
            $_POST['dob'],
            $_POST['gender'],
            $_POST['mobile'],
            $_POST['email'],
            $_POST['srcode'],
            $_POST['year']
        );
        
        $stmt->execute();
        $application_id = $conn->insert_id;

        header("Location: user_application-history.php?id=" . $application_id);
        exit();

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>