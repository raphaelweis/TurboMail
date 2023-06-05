<?php

use TurboMail\Model\MessageController;

include_once 'Model/MessageController.php';

if (isset($_POST['idSender'], $_POST['idReceiver'], $_POST['messageContent'])) {
    $message = new MessageController($_POST['idSender'], $_POST['idReceiver'], $_POST['messageContent']);
    echo $message->insertIntoDB();
}