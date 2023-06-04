<?php

use TurboMail\Model\UserController;

include_once 'Model/UserController.php';

session_start();

$array = [];
if (!empty($_SESSION)) {
    foreach ($_SESSION as $key => $value) {
        $array[$key] = $value;
    }
} else {
    $array = null;
}

echo json_encode($array);