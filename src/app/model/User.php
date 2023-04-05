<?php

include_once("ErrorCodes.php");

const EMAIL_REGEX = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
 
class User {
  // Properties
  protected $email;
  protected $password;

  // Methods
  public function __construct($email, $password) {
    $this->email = $email;
    $this->password = $password;
  }

  public function signIn(): int {
    if(!preg_match(EMAIL_REGEX, $this->email)) {
      return INVALID_EMAIL;
    }
    if(empty($this->password)) {
      return INVALID_PASSWORD;
    }

    if(!$this->checkEmail()) {
      return EMAIL_NOT_FOUND;
    }
    if(!$this->checkPassword()) {
      return WRONG_PASSWORD;
    }

    return SUCCESS;
  }

  public function checkEmail(): bool{
    // TODO
    // Check if the email is in the User table of TurboMail's database
    return true;
  }
  
  public function checkPassword(): bool {
    // TODO
    // Check if for the checked email we have this password in the User table of TurboMail's database
    return true;
  }
}

?>