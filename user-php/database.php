<?php

class Database {
    protected $host = "localhost";
    protected $db_name = "db_scholarshiptracker";
    protected $username = "root";
    protected $password = "";
    protected $conn = null;

    public function getConnection() {
        return $this->connect();
    }

    protected function connect() {
        $mysqli = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
        
        return $mysqli;
    }
}