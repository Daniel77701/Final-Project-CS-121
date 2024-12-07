<?php
require_once __DIR__ . '/Database.php';

class Application extends Database {
    private $appNo;
    private $scholarshipType;
    private $name;
    private $mobileNumber;
    private $applyDate;
    private $status;

    public function __construct($appNo, $scholarshipType, $name, $mobileNumber, $applyDate, $status) {
        parent::__construct(); 
        $this->appNo = $appNo;
        $this->scholarshipType = $scholarshipType;
        $this->name = $name;
        $this->mobileNumber = $mobileNumber;
        $this->applyDate = $applyDate;
        $this->status = $status;
    }

    public function save() {
        try {
            $query = "INSERT INTO applications (app_no, scholarship_type, name, mobile_number, apply_date, status) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                $this->appNo,
                $this->scholarshipType,
                $this->name,
                $this->mobileNumber,
                $this->applyDate,
                $this->status
            ]);
        } catch (PDOException $e) {
            error_log("Error saving application: " . $e->getMessage());
            return false;
        }
    }
}
?>
