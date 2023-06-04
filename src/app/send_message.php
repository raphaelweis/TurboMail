<?php

use TurboMail\Model\Message;

include_once 'Model/Message.php';

if (isset($_POST['idSender'], $_POST['idReceiver'], $_POST['messageContent'])) {
    $message = new Message($_POST['idSender'], $_POST['idReceiver'], $_POST['messageContent']);
    echo $message->insertIntoDB();
}