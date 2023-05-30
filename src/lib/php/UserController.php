<?php

namespace TurboMail;

include_once 'User.php';
include_once 'const/global.php';

class UserController extends User {
    private string $email;
    private string $password;

    public function __construct($email, $password) {
        $this->email = trim(htmlspecialchars($email));
        $this->password = trim(htmlspecialchars($password));
    }

    public function loginUser(): int {
        if ($this->emptyInput()) {
            return 1;
        }
        if ($this->invalidEmail()) {
            return 1;
        }
        if ($this->invalidPassword()) {
            return 1;
        }

        return $this->getUser($this->email, $this->password);
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
