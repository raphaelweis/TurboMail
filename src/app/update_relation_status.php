<?php

use TurboMail\Model\RelationController;

include_once __DIR__.'/Model/RelationController.php';

if (isset($_POST['new_status'], $_POST['id_relation'])) {
    $newStatus = trim(htmlspecialchars($_POST['new_status']));
    $idRelation = trim(htmlspecialchars($_POST['id_relation']));
    echo RelationController::AcceptRelation($newStatus, $_POST['id_relation']);
}