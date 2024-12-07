<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $dbName = "db_scholarshiptracker";
    private $conn;

    public function connect() {
        try {
            $mysqli = new mysqli($this->host, $this->user, $this->pwd, $this->dbName);
            
            if ($mysqli->connect_error) {
                throw new Exception("Connection failed: " . $mysqli->connect_error);
            }
            
            return $mysqli;
        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw $e;
        }
    }

    public function getConnection() {
        if (!$this->conn) {
            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->user, $this->pwd);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                error_log("Connection failed: " . $e->getMessage());
                throw $e;
            }
        }
        return $this->conn;
    }
}