<?php

include_once("ErrorCodes.php");

const EMAIL_REGEX = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
const PASSWORD_REGEX = "/^[a-zA-Z0-9\-\/\*\&\%\$\#\@\!\?]+$/";
 
class User {
  //
  // Properties
  //
  protected $email;
  protected $password;

  /**
   * Constructor
   * 
   * @var mixed $email User's email
   * @var mixed $password User's password
   */
  public function __construct($email, $password) {
    $this->email = $email;
    $this->password = $password;
  }


  //
  // Methods
  //

  /**
   * Sign in function
   * Check all inputs of the sign in form
   * Return the appropriate error in case of problem
   */
  public function signIn(): int {
    if(!$this->checkValidEmail()) {
      return INVALID_EMAIL;
    }
    if(!$this->checkExistingEmail()) {
      return EMAIL_NOT_FOUND;
    }

    if(!$this->checkValidPassword()) {
      return INVALID_PASSWORD;
    }
    if(!$this->checkGoodPassword()) {
      return WRONG_PASSWORD;
    }

    return SUCCESS;
  }

  /**
   * Function to check the user's email syntax
   */
  public function checkValidEmail(): bool{
    if(empty($this->email)) {
      return false;
    }

    if(!preg_match(EMAIL_REGEX, $this->email)) {
      return false;
    }

    return true;
  }

  /**
   * Function to search the user's email in the database
   */
  public function checkExistingEmail(): bool {
    // Check if the email is in the User table of TurboMail's database
    return true;
  }
  
  /**
   * Function to check the user's password syntax
   */
  public function checkValidPassword(): bool {
    if(empty($this->password)) {
      return false;
    }
    
    if(strlen($this->password) > 256) {
      return false;
    }

    if(!preg_match(PASSWORD_REGEX, $this->password)) {
      return false;
    }

    return true;
  }

  /**
   * Function to check if the user's password is in the database
   */
  public function checkGoodPassword(): bool {
    // Check if for the checked email we have this password in the User table of TurboMail's database
    return true;
  }
}

?>