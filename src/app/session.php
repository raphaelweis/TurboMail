<?php

// Start the user's session
session_start();

// Get the session's variable to save it
$array = [];
if (!empty($_SESSION)) {
    foreach ($_SESSION as $key => $value) {
        $array[$key] = $value;
    }
} else {
    $array = null;
}

echo json_encode($array);