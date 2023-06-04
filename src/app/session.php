<?php

use TurboMail\Model\UserController;

include_once 'Model/UserController.php';

session_start();

$array = [];
if (!empty($_SESSION)) {
    foreach ($_SESSION as $key => $value) {
        $array[$key] = $value;
    }
    $user = new UserController($array['s_Email']);
    $idUser = $user->GetUserIdByEmail($array['s_Email']);
    $relations = $user->FetchRelations($idUser);
    $array['relations'] = $relations;
} else {
    $array = null;
}

echo json_encode($array);