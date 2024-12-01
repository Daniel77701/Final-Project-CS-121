<?php
require_once 'Database.php'; 

class Schema {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection(); 
    }

    public function fetchAll() {
        $query = "SELECT * FROM schemas"; 
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
?>
