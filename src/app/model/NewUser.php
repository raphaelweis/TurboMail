<?php

include_once("ErrorCodes.php");

//const NAMES_REGEX = "/^([ \u00c0-\u01ffa-zA-Z'\-])+$/";
const NAMES_REGEX = "/^([a-z])/";

class NewUser extends User {
  private $firstName;
  private $lastName;
  private $checkPassword;

  public function __construct($email, $firstName, $lastName, $password, $checkPassword) {
    $this->email = $email;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->password = $password;
    $this->checkPassword = $checkPassword;
  }

  public function signUp(): int {
    if(!preg_match(EMAIL_REGEX, $this->email)) {
      return INVALID_EMAIL;
    }
    if(!$this->checkFirstName()) {

    }
    if(empty($this->password)) {
      return INVALID_PASSWORD;
    }
    if(!$this->checkPasswords()) {
      return PASSWORDS_DONT_MATCH;
    }

    return SUCCESS;
  }

  public function checkFirstName(): bool {
    // Check if != 0
    if(empty($this->firstName)) {
      return false;
    }

    // Check if <= 100
    if(strlen($this->firstName > 100)) {
      return false;
    }

    // Check if preg_match
    

    return true;
  }

  public function checkLastName(): bool {
    // Check if != 0
    // Check if <= 100
    // Check if preg_match
    return true;
  }

  public function checkPasswords(): bool {
    return $this->password == $this->checkPassword;
  }
}

echo "Résultat : " . preg_match(NAMES_REGEX, "Sam");

?>