<?php

class User {
  // Properties
  private $email;
  private $firstname;
  private $lastname;
  private $hashedPassword;

  // Methods
  function signIn() {

  }

  function signUp() {

  }
}

include_once("database.php");

$email = urldecode($_POST["email"]);
$password = urldecode($_POST["password"]);
$emailRegEx = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";

if(!preg_match($emailRegEx, $email)) {
  echo "Email don't match to email synthax";
}
if(empty($password)) {
  echo "Password missing";
}

// Read from database
$query = "SELECT * FROM users WHERE Email = '$email' AND Passwd = '$password'";
$result = $conn->query($query);

if($result) {
  echo "Login successful !";
}

?>
