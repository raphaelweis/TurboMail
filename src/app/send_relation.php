<?php

use TurboMail\Model\RelationController;

session_start();

if(isset($_POST['email-searched'], $_POST['asking-message'])) {
    $idSender = $_SESSION['s_ID'];
    $emailReceiver = trim(htmlspecialchars($_POST['email-searched']));
    $message = trim(htmlspecialchars($_POST['asking-message']));

    $relation = new RelationController($idSender, $emailReceiver, $message);

    echo $relation->sendRelation();
}

echo "Success";