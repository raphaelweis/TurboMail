<?php

use TurboMail\Model\NewUserController;

include_once 'Model/NewUserController.php';

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

    echo json_encode($signup->SignupUser());
}
