<?php
function getUserScholarshipStatus($conn, $student_no) {
    error_log("Checking scholarship status for student: " . $student_no);
    
    $query = "SELECT 
                sr.status,
                sr.course,
                sr.year_level,
                sr.created_at,
                s.scholarship_name,
                s.type,
                u.firstname,
                u.lastname,
                u.student_no,
                u.email,
                u.contact_no
              FROM users u
              LEFT JOIN scholarship_request sr ON u.student_no = sr.student_no
              LEFT JOIN scholarships s ON sr.scholarship_id = s.id
              WHERE u.student_no = ?
              ORDER BY sr.created_at DESC
              LIMIT 1";
    
    try {
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return null;
        }
        
        $stmt->bind_param("s", $student_no);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return null;
        }
        
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            error_log("Retrieved scholarship data: " . print_r($row, true));
            
            return [
                'status' => $row['status'] ?? 'No Application',
                'scholarship' => $row['scholarship_name'] ?? '',
                'type' => $row['type'] ?? '',
                'course' => $row['course'] ?? '',
                'year_level' => $row['year_level'] ?? '',
                'created_at' => $row['created_at'] ?? '',
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'student_no' => $row['student_no'],
                'email' => $row['email'],
                'contact_no' => $row['contact_no']
            ];
        } else {
            error_log("No user profile found for student: " . $student_no);
            return null;
        }
    } catch (Exception $e) {
        error_log("Error in getUserScholarshipStatus: " . $e->getMessage());
        return null;
    }
}

// Add this function to check data
function debugScholarshipData($conn, $student_no) {
    $query = "SELECT * FROM scholarship_request WHERE student_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $student_no);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            error_log("Raw scholarship data: " . print_r($row, true));
        }
    } else {
        error_log("No data found for student: " . $student_no);
    }
} 