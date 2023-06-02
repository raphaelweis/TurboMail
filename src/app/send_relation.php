<?php

use TurboMail\Model\UserController;

include_once './Model/UserController.php';

session_start();

if(isset($_POST['email-searched'], $_POST['asking-message'])) {
    $idSender = $_SESSION['s_ID'];

    $emailReceiver = trim(htmlspecialchars($_POST['email-searched']));
    $message = trim(htmlspecialchars($_POST['asking-message']));

    $user = new UserController($_SESSION['s_Email']);

    $user->AddFriend($idSender, $emailReceiver, $message);
}
