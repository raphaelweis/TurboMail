<?php

use TurboMail\NewUserController as NewUserController;

include_once 'NewUserController.php';

$debug = 0;

/* @noinspection PhpConditionAlreadyCheckedInspection */
if ($debug) {
    $firstName = 'Stephen';
    $lastName = 'Curry';
    $email = 'stephen.curry@nba.com';
    $password = 'bang!bang!';
    $passwordCheck = 'bang!bang!';

    // Instantiate SignupContr class
    $signup = new NewUserController(
        $firstName,
        $lastName,
        $email,
        $password,
        $passwordCheck
    );

    // Running error handlers and user register operation
    echo $signup->signupUser();
}

// Grabbing the data
if (isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['password-check'])) {
    $firstName = trim(htmlspecialchars($_POST['firstname']));
    $lastName = trim(htmlspecialchars($_POST['lastname']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $passwordCheck = trim(htmlspecialchars($_POST['password-check']));

    $signup = new NewUserController(
        $firstName,
        $lastName,
        $email,
        $password,
        $passwordCheck
    );
    // Running error handlers and user register operation
    echo $signup->signupUser();
}