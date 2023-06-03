<?php

use TurboMail\Model\UserController;

include_once __DIR__ . '/Model/UserController.php';

session_start();

if(isset($_POST['email-searched'], $_POST['request-message'])) {
    $idSender = $_SESSION['s_ID'];

    $emailReceiver = trim(htmlspecialchars($_POST['email-searched']));
    $message = trim(htmlspecialchars($_POST['request-message']));

    $user = new UserController($_SESSION['s_Email']);

    echo $user->AddFriend($idSender, $emailReceiver, $message);
}
