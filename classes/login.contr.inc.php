<?php
require_once 'login.classes.php';
require_once 'LoginTracker.php';

class LoginContr extends Login {
    private $sr_code;
    private $pwd;
    private $loginTracker;

    public function __construct($sr_code, $pwd) {
        parent::__construct();
        $this->sr_code = $sr_code;
        $this->pwd = $pwd;
        $this->loginTracker = new LoginTracker();
    }

    public function loginUser() {
        if ($this->emptyInput()) {
            header("location: ../html/user_login.html?error=emptyinput");
            exit();
        }

        try {
            $student = $this->getUser($this->sr_code, $this->pwd);
            if ($student) {
                session_start();
                $_SESSION["user_id"] = $student["id"];
                $_SESSION["user_srcode"] = $student["sr_code"];
                $_SESSION["user_name"] = $student["name"];
                $_SESSION["user_email"] = $student["email"];
                
                // Log the login
                $this->loginTracker->logLogin($student["id"]);
                
                header("location: ../php/user_dashboard.php");
                exit();
            } else {
                header("location: ../html/user_login.html?error=wronglogin");
                exit();
            }
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            header("location: ../html/user_login.html?error=stmtfailed");
            exit();
        }
    }

    private function emptyInput() {
        return empty($this->sr_code) || empty($this->pwd);
    }
} 