<?php

class LoginContr extends Login {
    private $email;
    private $password;

    public function __construct($email, $password) {
        $this->email = trim(htmlspecialchars($email));
        $this->password = trim(htmlspecialchars($password));
    }

    public function loginUser() {
        if ($this->emptyInput()) {
            header('Location: ../../public/login/login.html?error=input');
            exit();
        }

        $this->getUser($this->email, $this->password);
    }

    private function emptyInput(): bool {
        if (empty($this->email) || empty($this->password)) {
            return true;
        }

        return false;
    }
}
