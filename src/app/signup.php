<?php

require_once('classes/NewUser.php');

$newUser = new NewUser($_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['password'], $_POST['passwordcheck']);
$newUser->signUp();

?>