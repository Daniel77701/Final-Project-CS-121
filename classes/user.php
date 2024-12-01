<?php
class User extends Database {
    private $name;
    private $email;
    private $srCode;
    private $mobileNumber;
    private $password;

    public function __construct($name, $email, $srCode, $mobileNumber, $password) {
        parent::__construct();
        $this->name = $name;
        $this->email = $email;
        $this->srCode = $srCode;
        $this->mobileNumber = $mobileNumber;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getSrCode() {
        return $this->srCode;
    }

    public function save() {
        $query = "INSERT INTO users (name, email, sr_code, mobile_number, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $this->name, $this->email, $this->srCode, $this->mobileNumber, $this->password,
        ]);
    }

    public function getUserDetails() {
        return [
            'Name' => $this->name,
            'Email' => $this->email,
            'SR Code' => $this->srCode,
            'Mobile Number' => $this->mobileNumber,
        ];
    }

    public function updateProfile($data) {
        $query = "UPDATE users SET name = ?, email = ?, mobile_number = ? WHERE sr_code = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['name'], 
            $data['email'], 
            $data['mobile_number'], 
            $this->getSrCode(), 
        ]);
    }

    public function verifyPassword($inputPassword, $storedPassword) {
        return password_verify($inputPassword, $storedPassword);
    }
}

try {
    $newUser = new User('John Doe', 'john.doe@example.com', 'SR12345', '09171234567', 'securepassword');

    if ($newUser->save()) {
        echo "User saved successfully!<br>";
    } else {
        echo "Failed to save user.<br>";
    }

    $userDetails = $newUser->getUserDetails();
    echo "<pre>";
    print_r($userDetails);
    echo "</pre>";

    $updatedData = [
        'name' => 'Johnathan Doe',
        'email' => 'john.doe.updated@example.com',
        'mobile_number' => '09179876543',
    ];
    if ($newUser->updateProfile($updatedData)) {
        echo "Profile updated successfully!<br>";
    } else {
        echo "Failed to update profile.<br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>