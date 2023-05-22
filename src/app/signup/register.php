<?php

echo 'Bonjour';

use TurboMail\NewUserController as NewUserController;

include_once 'NewUserController.php';

//if (isset($_POST['submit'])) {
if (1) {
    // Grabbing the data
    $firstName = trim(htmlspecialchars($_POST['firstname']));
    $lastName = trim(htmlspecialchars($_POST['lastname']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $passwordCheck = trim(htmlspecialchars($_POST['password-check']));

    // Instantiate SignupContr class
    $signup = new NewUserController(
        $firstName,
        $lastName,
        $email,
        $password,
        $passwordCheck
    );

    // Running error handlers and user signup
    echo $signup->signupUser();
}