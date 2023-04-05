<?php

include_once("ErrorCodes.php");

const NAMES_REGEX = "/^(?!\s)[a-zA-Z\'\-\sÀ-ÖØ-öø-ÿ]+$/u";

class NewUser extends User {
  private $firstName;
  private $lastName;
  private $checkPassword;

  public function __construct($email, $firstName, $lastName, $password, $checkPassword) {
    parent::__construct($email, $password);
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->checkPassword = $checkPassword;
  }

  public function signUp(): int {
    if(!$this->checkValidEmail()) {
      return INVALID_EMAIL;
    }
    if($this->checkExistingEmail()) {
      return EMAIL_IN_USE;
    }

    if(!$this->checkFirstName()) {
      return INVALID_FIRSTNAME;
    }

    if(!$this->checkLastName()) {
      return INVALID_LASTNAME;
    }

    if(!$this->checkPasswords()) {
      return PASSWORDS_DONT_MATCH;
    }

    return SUCCESS;
  }

  public function checkFirstName(): bool {
    if(empty($this->firstName)) {
      return false;
    }

    if(strlen($this->firstName > 100)) {
      return false;
    }

    if(!preg_match(NAMES_REGEX, $this->firstName)) {
      return false;
    }

    return true;
  }

  public function checkLastName(): bool {
    if(empty($this->lastName)) {
      return false;
    }

    if(strlen($this->lastName > 100)) {
      return false;
    }

    if(!preg_match(NAMES_REGEX, $this->lastName)) {
      return false;
    }
    return true;
  }

  public function checkPasswords(): bool {
    return $this->password == $this->checkPassword;
  }
}

?>