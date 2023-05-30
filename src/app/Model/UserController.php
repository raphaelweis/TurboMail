<?php

namespace TurboMail\Model;

include_once 'User.php';
include_once __DIR__ . '/../const/global.php';

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

        if(strlen($this->email) > MAX_EMAIL_LENGTH) {
            return true;
        }

        return false;
    }

    private function invalidPassword(): bool {
        if (!preg_match(PASSWORD_REGEX, $this->password)) {
            return true;
        }

        if (strlen($this->password) < MIN_PASSWORD_LENGTH || strlen($this->password) > MAX_PASSWORD_LENGTH) {
            return true;
        }

        return false;
    }
}
