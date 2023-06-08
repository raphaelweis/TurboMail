<?php

use TurboMail\Model\RelationController;

include_once __DIR__.'/Model/RelationController.php';

if (isset($_POST['id_relation'])) {
    $idRelation = trim(htmlspecialchars($_POST['id_relation']));
    echo RelationController::DeleteMessagesAndRelation($idRelation);
}
