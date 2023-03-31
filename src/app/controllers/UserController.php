<?php

class UserController {
    private $user;

    /**
     * @param  mixed  $user
     */
    public function __construct() {
        $email = $_POST['email'];
        $password = $_POST['password'];
//        $this->user = new User($email, $password);
    }

    /**
     * @param  mixed  $user
     */
    public function login(): void {
        echo 'success';
        //TODO : check if there is a match in the database
        // if there is : echo "success", if there isnt : echo "failure"
        // if ($this->user->authenticateUser()) {
        //     echo 'success';
        // } else {
        //     echo 'failure';
        // }
    }

    public function getUser(): User {
        return $this->user;
    }
}

//call login function

$userController = new UserController();
$userController->login();
