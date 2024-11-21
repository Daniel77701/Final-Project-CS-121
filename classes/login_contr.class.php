<?php

class LoginContr extends Login {

    private $email;
    private $Sr_code;
    private $password;

    public function __construct($email, $Sr_code, $password) {
        $this->email = $email;
        $this->Sr_code = $Sr_code;
        $this->password = $password;
    }

    public function loginStudent() {
        if ($this->emptyInput()) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }

        if (!$this->validateSrCode($this->Sr_code)) {
            header("location: ../index.php?error=invalidsrcode");
            exit();
        }

        $this->getStudent($this->email, $this->Sr_code, $this->password);
    }

    private function validateSrCode($Sr_code) {
        $pattern = '/^\d{2}-\d{1,5}$/';
        return preg_match($pattern, $Sr_code);
    }

    private function emptyInput() {
        return empty($this->email) || empty($this->Sr_code) || empty($this->password);
    }
}

?>
