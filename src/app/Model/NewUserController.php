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
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $passwordCheck
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->passwordCheck = $passwordCheck;
    }

    // Methods

    public function SignupUser(): string {
        $errors = [];

        if ($this->EmptyInput()) {
            $errors[] = 1;
        }
        if ($this->InvalidFirstName()) {
            $errors[] = 2;
        }
        if ($this->InvalidLastName()) {
            $errors[] = 3;
        }
        if ($this->InvalidEmail()) {
            $errors[] = 4;
        }
        if ($this->InvalidPassword()) {
            $errors[] = 5;
        }
        if (!$this->PasswordMatch()) {
            $errors[] = 6;
        }
        if ($this->EmailTakenCheck()) {
            $errors[] = 7;
        }

        if (count($errors) == 0) {
            $status = $this->SetUser(
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

    private function EmptyInput(): bool {
        if (empty($this->firstName) || empty($this->lastName)
            || empty($this->email)
            || empty($this->password)
            || empty($this->passwordCheck)
        ) {
            return true;
        }

        return false;
    }

    private function InvalidFirstName(): bool {
        if(strlen($this->firstName) > MAX_FIRST_NAME_LENGTH) {
            return true;
        }

        if (!preg_match(NAMES_REGEX, $this->firstName)) {
            return true;
        }

        return false;
    }

    private function InvalidLastName(): bool {
        if(strlen($this->lastName) > MAX_LAST_NAME_LENGTH) {
            return true;
        }

        if (!preg_match(NAMES_REGEX, $this->firstName)) {
            return true;
        }

        return false;
    }

    private function InvalidEmail(): bool {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    private function InvalidPassword(): bool {
        if (strlen($this->password) < 8 || strlen($this->password) > 128) {
            return true;
        }

        if (!preg_match(PASSWORD_REGEX, $this->password)) {
            return true;
        }

        return false;
    }

    private function PasswordMatch(): bool {
        if ($this->password == $this->passwordCheck) {
            return true;
        }

        return false;
    }

    private function EmailTakenCheck(): bool {
        if ($this->UserAlreadyExist($this->email)) {
            return true;
        }

        return false;
    }
}
