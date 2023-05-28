<?php

// Start the user's session
session_start();

// Get the session's variable to save it
foreach ($_SESSION as $key => $value) {
    $array[$key] = $value;
}

echo json_encode($array);
