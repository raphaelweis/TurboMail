<?php

$firstName = urldecode($_POST["firstName"]);
$lastName = urldecode($_POST["lastName"]);
$email = urldecode($_POST["email"]);
$password = urldecode($_POST["password"]);
$passwordCheck = urldecode($_POST["passwordCheck"]);

$returnData = array('firstName' => $firstName,
  'lastName' => $lastName, 
  'email' => $email, 
  'password' => $password, 
  'passwordCheck' => $passwordCheck);

$returnJson = json_encode($returnData);

// not necessary but recommended
header("Content-Type: application/json");
echo $returnJson;

?>
