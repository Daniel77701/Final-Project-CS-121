<?php
require_once 'login.classes.php';
require_once 'LoginTracker.php';

class LoginContr extends Login {
    private $login_id;
    private $pwd;
    private $loginTracker;

    public function __construct($login_id, $pwd) {
        try {
            parent::__construct();
            $this->login_id = $login_id;
            $this->pwd = $pwd;
            $this->loginTracker = new LoginTracker();
        } catch (Exception $e) {
            error_log("LoginContr constructor error: " . $e->getMessage());
            throw $e;
        }
    }

    public function loginUser() {
        try {
            if ($this->emptyInput()) {
                header("location: ../html/user_login.html?error=empty");
                exit();
            }

            $student = $this->getUser($this->login_id, $this->pwd);
            
            if ($student) {
                session_start();
                $_SESSION['user_id'] = $student['id'];
                $_SESSION['user_srcode'] = $student['sr_code'];
                $_SESSION['user_name'] = $student['name'];
                $_SESSION['user_email'] = $student['email'];

                $this->loginTracker->logLogin($student['id']);
                header("location: ../php/user_dashboard.php");
                exit();
            }

            header("location: ../html/user_login.html?error=invalid");
            exit();

        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            header("location: ../html/user_login.html?error=system");
            exit();
        }
    }

    private function emptyInput() {
        return empty($this->login_id) || empty($this->pwd);
    }
} 