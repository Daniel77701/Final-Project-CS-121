<?php

class LoginContr extends Login {

    private $uid;
    private $pwd;

    public function __construct($uid, $pwd) {
        $this->uid = $uid;
        $this->pwd = $pwd;
    }

    public function loginUser() {
        if($this->emptyInput() == false) {
            header("location: ../user_login.html?error=emptyinput");
            exit();
        }

        return $this->getUser($this->uid, $this->pwd);
    }

    private function emptyInput() {
        if(empty($this->uid) || empty($this->pwd)) {
            return false;
        }
        return true;
    }
}

?>
