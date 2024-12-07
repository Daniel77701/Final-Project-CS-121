<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();
    
    try {
        require_once 'database.php';
        $db = new Database();
        $conn = $db->connect();
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['pwd'];
        
        // First check if user exists
        $query = "SELECT * FROM students WHERE (email = ? OR sr_code = ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify if name matches
            if ($name === $user['name'] && $password === $user['password']) {
                $response['status'] = 'success';
                $response['message'] = 'Login successful';
                $response['data'] = array(
                    'name' => $user['name'],
                    'email' => $user['email']
                );
                
                // Start session and store user data
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Invalid credentials';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'User not found';
        }
        
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?> 