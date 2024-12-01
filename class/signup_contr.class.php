<?php

class SignupContr extends Signup {

    private $name;
    private $email;
    private $srcode;
    private $mobile;
    private $pwd;
    private $pwdRepeat;

    public function __construct($name, $email, $srcode, $mobile, $pwd, $pwdRepeat) {
        $this->name = $name;
        $this->email = $email;
        $this->srcode = $srcode;
        $this->mobile = $mobile;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
    }

    public function signupUser() {
        if($this->emptyInput() == false) {
            throw new Exception("emptyinput");
        }
        if($this->invalidEmail() == false) {
            throw new Exception("email");
        }
        if($this->pwdMatch() == false) {
            throw new Exception("passwordmatch");
        }
        if($this->srCodeCheck() == false) {
            throw new Exception("srcode");
        }
        if($this->userExists() == false) {
            throw new Exception("useroremailtaken");
        }

        $this->setUser($this->name, $this->email, $this->srcode, $this->mobile, $this->pwd);
    }

    private function emptyInput() {
        if(empty($this->name) || empty($this->email) || empty($this->srcode) || 
           empty($this->mobile) || empty($this->pwd) || empty($this->pwdRepeat)) {
            return false;
        }
        return true;
    }

    private function invalidEmail() {
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    private function pwdMatch() {
        if($this->pwd !== $this->pwdRepeat) {
            return false;
        }
        return true;
    }

    private function srCodeCheck() {
        if(!preg_match("/^[0-9]{2}-[0-9]{5}$/", $this->srcode)) {
            return false;
        }
        return true;
    }

    private function userExists() {
        return $this->checkUser($this->email, $this->srcode);
    }
}


?>
