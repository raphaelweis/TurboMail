<?php

use TurboMail\Model\Message;

include_once 'Model/Message.php';

$relations = [];
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $user = new UserController($email);
    $idUser = $user->GetUserIdByEmail($email);
    $relations = $user->FetchRelations($idUser);
}

echo json_encode($relations);
