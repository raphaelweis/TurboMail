<?php

namespace TurboMail\Model;

include_once 'NewUser.php';
include_once __DIR__ . '/../const/global.php';

class NewUserController extends NewUser {
    // Properties
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private string $passwordCheck;

    // Constructor
    public function __construct(
        $firstName,
        $lastName,
        $email,
        $password,
        $passwordCheck
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->passwordCheck = $passwordCheck;
    }

    // Methods

    public function signupUser(): string {
        $errors = [];

        if ($this->emptyInput()) {
            $errors[] = 1;
        }
        if ($this->invalidFirstName()) {
            $errors[] = 2;
        }
        if ($this->invalidLastName()) {
            $errors[] = 3;
        }
        if ($this->invalidEmail()) {
            $errors[] = 4;
        }
        if ($this->invalidPassword()) {
            $errors[] = 5;
        }
        if (!$this->passwordMatch()) {
            $errors[] = 6;
        }
        if ($this->emailTakenCheck()) {
            $errors[] = 7;
        }

        if (count($errors) == 0) {
            $status = $this->setUser(
                $this->firstName,
                $this->lastName,
                $this->email,
                $this->password
            );
            if ($status) {
                $errors[] = 500;
            } else {
                $errors[] = 0;
            }
        }

        return json_encode($errors);
    }

    private function emptyInput(): bool {
        if (empty($this->firstName) || empty($this->lastName)
            || empty($this->email)
            || empty($this->password)
            || empty($this->passwordCheck)
        ) {
            return true;
        }

        return false;
    }

    private function invalidFirstName(): bool {
        if (!preg_match(NAMES_REGEX, $this->firstName)) {
            return true;
        }

        if(strlen($this->firstName) > MAX_FIRST_NAME_LENGTH) {
            return true;
        }

        return false;
    }

    private function invalidLastName(): bool {
        if (!preg_match(NAMES_REGEX, $this->lastName)) {
            return true;
        }

        if(strlen($this->lastName) > MAX_LAST_NAME_LENGTH) {
            return true;
        }

        return false;
    }

    private function invalidEmail(): bool {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        if(strlen($this->email) > MAX_EMAIL_LENGTH)

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
