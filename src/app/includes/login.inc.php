<?php

if (isset($_POST['submit'])) {
    // Grabbing the data
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    // Instantiate SignupContr class
    include '../classes/dbh.classes.php';
    include '../classes/login.classes.php';
    include '../classes/login-contr.classes.php';
    $login = new LoginContr($email, $password);

    // Running error handlers and user signup
    $login->loginUser();

    // Going to back to front page
    header('Location: ../../public/login/login.html');

}
