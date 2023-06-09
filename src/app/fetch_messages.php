<?php

use TurboMail\Model\MessageController;

include_once 'Model/MessageController.php';

$relations = [];
if (isset($_POST['relationId'], $_POST['recentOnly'])) {
    $relationId = (int)trim(htmlspecialchars($_POST['relationId']));
    $recentOnly = filter_var($_POST['recentOnly'], FILTER_VALIDATE_BOOLEAN);
    echo json_encode(MessageController::getConversationMessages($relationId, $recentOnly));
}