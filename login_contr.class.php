<?php

class LoginContr extends Login {

    private $email;
    private $pwd;

    public function __construct($email, $pwd) {
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function loginUser() {
        if($this->emptyInput() == false) {
            throw new Exception("emptyinput");
        }

        return $this->getUser($this->email, $this->pwd);
    }

    private function emptyInput() {
        if(empty($this->email) || empty($this->pwd)) {
            return false;
        }
        return true;
    }
}

?>
