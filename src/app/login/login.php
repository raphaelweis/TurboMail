<?php

if (isset($_POST['submit'])) {
    // Grabbing the data
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    // Instantiate SignupContr class
    include '../database/DataBaseHandler.php';
    include 'User.php';
    include 'UserController.php';
    $login = new UserController($email, $password);

    // Running error handlers and user login
    $login->loginUser();

    // Going to back to front page
    header('Location: ../public/message/message.html');
}
