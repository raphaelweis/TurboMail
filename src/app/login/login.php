<?php

use TurboMail\UserController as UserController;

include_once 'UserController.php';

$debug = 1;

/* @noinspection PhpConditionAlreadyCheckedInspection */
if ($debug) {
    $email = 'stephen.curry@nba.com';
    $password = 'bang!bang!';

    $login = new UserController($email, $password);
    echo $login->loginUser();
}

if (isset($_POST['email'], $_POST['password'])) {
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));

    $login = new UserController($email, $password);
    echo $login->loginUser();
}