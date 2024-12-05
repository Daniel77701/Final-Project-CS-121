<?php

class ScholarshipRequest extends Dbh {
    
    public function getAllRequests() {
        try {
            $stmt = $this->connect()->prepare("SELECT 
                scholarship_id,
                type,
                scholarship,
                student_no,
                name,
                course,
                year_level,
                COALESCE(status, 'Pending') as status 
            FROM scholarship_request 
            ORDER BY scholarship_id DESC");
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error fetching requests: " . $e->getMessage();
            return [];
        }
    }

    public function getUserScholarshipStatus($student_no) {
        try {
            $stmt = $this->connect()->prepare("SELECT sr.*, s.name as scholarship_name 
                FROM scholarship_request sr 
                WHERE sr.student_no = ? 
                ORDER BY scholarship_id DESC 
                LIMIT 1");
            
            $stmt->execute([$student_no]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Error fetching status: " . $e->getMessage();
            return null;
        }
    }

    public function addRequest($type, $scholarship, $student_no, $name, $course, $year_level, $status) {
        try {
            $stmt = $this->connect()->prepare("INSERT INTO scholarship_request 
                (type, scholarship, student_no, name, course, year_level, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->execute([$type, $scholarship, $student_no, $name, $course, $year_level, $status]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error adding request: " . $e->getMessage());
        }
    }

    public function updateRequest($id, $type, $scholarship, $student_no, $name, $course, $year_level, $status) {
        try {
            $stmt = $this->connect()->prepare("UPDATE scholarship_request 
                SET type=?, scholarship=?, student_no=?, name=?, course=?, year_level=?, status=? 
                WHERE scholarship_id=?");
            
            $stmt->execute([$type, $scholarship, $student_no, $name, $course, $year_level, $status, $id]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error updating request: " . $e->getMessage());
        }
    }

    public function deleteRequest($id) {
        try {
            $stmt = $this->connect()->prepare("DELETE FROM scholarship_request WHERE scholarship_id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error deleting request: " . $e->getMessage());
        }
    }
}