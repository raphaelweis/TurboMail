<?php

use TurboMail\Model\UserController;

require_once 'Model/UserController.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    $login = new UserController($email, $password);
    echo $login->loginUser();
}
