<?php

use TurboMail\Model\Relation;

include_once __DIR__.'/Model/Relation.php';

if (isset($_POST['id_relation'])) {
    $relationStatus = 1;
    $relation = new Relation();
    echo $relation->AcceptRelation($relationStatus, $_POST['id_relation']);
}