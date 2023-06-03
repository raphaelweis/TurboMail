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

    private function EmptyInput(): int {
        if (empty($this->firstName) || empty($this->lastName)
            || empty($this->email)
            || empty($this->password)
            || empty($this->passwordCheck)
        ) {
            return 1;
        }

        return 0;
    }

    private function InvalidFirstName(): int {
        if(strlen($this->firstName) > MAX_FIRST_NAME_LENGTH) {
            return 1;
        }

        if (!preg_match(NAMES_REGEX, $this->firstName)) {
            return 1;
        }

        return 0;
    }

    private function InvalidLastName(): int {
        if(strlen($this->lastName) > MAX_LAST_NAME_LENGTH) {
            return 1;
        }

        if (!preg_match(NAMES_REGEX, $this->firstName)) {
            return 1;
        }

        return 0;
    }

    private function InvalidEmail(): int {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return 1;
        }

        return 0;
    }

    private function InvalidPassword(): int {
        if (strlen($this->password) < 8 || strlen($this->password) > 128) {
            return 1;
        }

        if (!preg_match(PASSWORD_REGEX, $this->password)) {
            return 1;
        }

        return 0;
    }

    private function PasswordMatch(): int {
        if ($this->password == $this->passwordCheck) {
            return 1;
        }

        return 0;
    }

    private function EmailTakenCheck(): int {
        if ($this->UserAlreadyExist($this->email)) {
            return 1;
        }

        return 0;
    }
}
