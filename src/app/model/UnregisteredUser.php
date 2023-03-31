<?php

class UnregisteredUser extends User {
    private $firstName;

    private $lastName;

    private $passwordCheck;

    /**
     * @param  mixed  $firstName
     * @param  mixed  $lastName
     * @param  mixed  $email
     * @param  mixed  $password
     * @param  mixed  $passwordCheck
     */
    public function __construct($firstName, $lastName, $email, $password, $passwordCheck) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->passwordCheck = $passwordCheck;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }
}
