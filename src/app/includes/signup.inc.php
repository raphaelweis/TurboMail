<?php

if (isset($_POST['submit'])) {
    // Grabbing the data
    $firstName = trim(htmlspecialchars($_POST['firstname']));
    $lastName = trim(htmlspecialchars($_POST['lastname']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $passwordCheck = trim(htmlspecialchars($_POST['password-check']));

    // Instantiate SignupContr class
    include '../classes/dbh.classes.php';
    include '../classes/signup.classes.php';
    include '../classes/signup-contr.classes.php';
    $signup = new SignupContr($firstName, $lastName, $email, $password, $passwordCheck);

    // Running error handlers and user signup
    $signup->signupUser();

    // Going to back to front page
    header('Location: ../../public/login/login.html');

}
