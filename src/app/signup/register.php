<?php

if (isset($_POST['submit'])) {
    // Grabbing the data
    $firstName = trim(htmlspecialchars($_POST['firstname']));
    $lastName = trim(htmlspecialchars($_POST['lastname']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $passwordCheck = trim(htmlspecialchars($_POST['password-check']));

    // Instantiate SignupContr class
    include '../database/DataBaseHandler.php';
    include 'NewUser.php';
    include 'NewUserController.php';
    $signup = new NewUserController($firstName, $lastName, $email, $password, $passwordCheck);

    // Running error handlers and user signup
    $signup->signupUser();

    echo json_encode([0]);
}
