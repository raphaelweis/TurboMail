<?php

use TurboMail\Model\MessageController;

include_once 'Model/MessageController.php';

if (isset($_POST['relationId'])) {
    $relationId = (int)trim(htmlspecialchars($_POST['relationId']));
    echo json_encode(MessageController::getConversationMessages($relationId));
}