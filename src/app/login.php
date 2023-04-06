<?php

$errors = array();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $errors[] = 500;
}
