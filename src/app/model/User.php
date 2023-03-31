<?php

class User {
    protected $email;

    protected $password;

    /**
     * @param  mixed  $email
     * @param  mixed  $password
     */
    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function authenticateUser(): bool {
        return true;
    }
}
