<?php

use app\classes\NewUser;

$newUser = new NewUser($_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['password'], $_POST['passwordcheck']);
$newUser->signUp();
