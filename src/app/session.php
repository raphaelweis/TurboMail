<?php

use TurboMail\Model\UserController;

include_once 'Model/UserController.php';

session_start();

$array = [];
if (!empty($_SESSION)) {
    foreach ($_SESSION as $key => $value) {
        $array[$key] = htmlspecialchars_decode($value);
    }
}

echo json_encode($array);