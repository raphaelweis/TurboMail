<?php

const NAMES_REGEX = "/^(?!\s)[a-zA-Z\'\-\sÀ-ÖØ-öø-ÿ]+$/u";
const PASSWORD_REGEX = "/^[a-zA-Z0-9\/!@#$%&*]+$/";

class SignupContr extends Signup {
    // Properties
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $passwordCheck;

    // Constructor
    public function __construct($firstName, $lastName, $email, $password, $passwordCheck) {
        $this->$firstName = $firstName;
        $this->$lastName = $lastName;
        $this->$email = $email;
        $this->$password = $password;
        $this->$passwordCheck = $passwordCheck;
    }

    // Methods

    public function signupUser(): void {
        if ($this->emptyInput()) {
            header('Location: ../../public/login/login.html?error=input');
            exit();
        }
        if ($this->invalidFirstName()) {
            header('Location: ../../public/login/login.html?error=firstname');
            exit();
        }
        if ($this->invalidLastName()) {
            header('Location: ../../public/login/login.html?error=lastname');
            exit();
        }
        if ($this->invalidEmail()) {
            header('Location: ../../public/login/login.html?error=email');
            exit();
        }
        if ($this->invalidPassword()) {
            header('Location: ../../public/login/login.html?error=password');
            exit();
        }
        if (!$this->passwordMatch()) {
            header('Location: ../../public/login/login.html?error=passwordmatch');
            exit();
        }
        if ($this->emailTakenCheck()) {
            header('Location: ../../public/login/login.html?error=emailtaken');
            exit();
        }

        $this->setUser($this->firstName, $this->lastName, $this->email, $this->password);

    }

    private function emptyInput(): bool {
        if (empty($this->firstName) || empty($this->lastName) || empty($this->email) || empty($this->password) || empty($this->passwordCheck)) {
            return true;
        }

        return false;
    }

    private function invalidFirstName(): bool {
        if (!preg_match(NAMES_REGEX, $this->firstName)) {
            return true;
        }

        return false;
    }

    private function invalidLastName(): bool {
        if (!preg_match(NAMES_REGEX, $this->firstName)) {
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

    private function passwordMatch(): bool {
        if ($this->password == $this->passwordCheck) {
            return true;
        }

        return false;
    }

    private function emailTakenCheck(): bool {
        if ($this->checkUser($this->email)) {
            return true;
        }

        return false;
    }
}
