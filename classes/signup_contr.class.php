<?php

class SignupContr extends Signup {

    private $Name;
    private $email;
    private $Sr_code;
    private $Mobilenum;
    private $password;
    private $passwordRepeat;

    public function __construct($Name, $email, $Sr_code, $Mobilenum, $password, $passwordRepeat) {
        $this->Name = $Name;
        $this->email = $email;
        $this->Sr_code = $Sr_code;
        $this->Mobilenum = $Mobilenum;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }

    //Error Handling
    public function signupStudent() {
        if ($this->emptyInput() == false) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }
        if ($this->invalidEmail() == false) {
            header("location: ../index.php?error=invalidemail");
            exit();
        }
        if ($this->passwordMatch() == false) {
            header("location: ../index.php?error=passwordmismatch");
            exit();
        }
        if ($this->validateSrCode($this->Sr_code) == false) {
            header("location: ../index.php?error=invalidsrcode");
            exit();
        }
        if ($this->studentExists() == true) {
            header("location: ../index.php?error=studentexists");
            exit();
        }

        //Add students

        $this->setStudent($this->Name, $this->email, $this->Sr_code, $this->Mobilenum, $this->password);
    }

    private function validateSrCode($Sr_code) {
        $pattern = '/^\d{2}-\d{1,5}$/';
        return preg_match($pattern, $Sr_code);
    }

    private function emptyInput() {
        return !(
            empty($this->Name) || 
            empty($this->email) || 
            empty($this->Sr_code) || 
            empty($this->Mobilenum) || 
            empty($this->password) || 
            empty($this->passwordRepeat)
        );
    }

    private function invalidEmail() {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    private function passwordMatch() {
        return $this->password === $this->passwordRepeat;
    }

    private function studentExists() {
        return $this->checkStudent($this->Sr_code, $this->email);
    }
}


?>
