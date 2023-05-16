<?php

const PASSWORD_REGEX = "/^[a-zA-Z0-9\/!@#$%&*]+$/";

class UserController extends User {
    private $email;
    private $password;

    public function __construct($email, $password) {
        $this->email = trim(htmlspecialchars($email));
        $this->password = trim(htmlspecialchars($password));
    }

    public function loginUser() {
        if ($this->emptyInput()) {
            header('Location: ../public/login/login.html?error=input');
            exit();
        }
        if ($this->invalidEmail()) {
            header('Location: ../public/login/login.html?error=email');
            exit();
        }
        if ($this->invalidPassword()) {
            header('Location: ../public/login/login.html?error=password');
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

    private function invalidEmail(): bool {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    private function invalidPassword(): bool {
        if (strlen($this->password) < 8 || strlen($this->password) > 128) {
            return true;
        }

        if (!preg_match(PASSWORD_REGEX, $this->password)) {
            return true;
        }

        return false;
    }
}
