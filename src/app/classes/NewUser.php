<?php

require_once("Database.php");
require_once("User.php");
require_once("ErrorCodes.php");

const NAMES_REGEX = "/^(?!\s)[a-zA-Z\'\-\sÀ-ÖØ-öø-ÿ]+$/u";

class NewUser extends User {
  //
  // Properties
  //
  private $firstName;
  private $lastName;
  private $checkPassword;


  /**
   * Constructor
   * 
   * @var mixed $email User's email
   * @var mixed $firstName User's first name
   * @var mixed $lastName User's last name
   * @var mixed $password User's password
   * @var mixed $checkPassword User's password
   */
  public function __construct($email, $firstName, $lastName, $password, $checkPassword) {
    parent::__construct($email, $password);
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->checkPassword = $checkPassword;
  }


  //
  // Methods
  //

  /**
   * Sign up fonction
   * Check all inputs of the sign up form
   * Return the appropriate error in case of problem
   */
  public function signUp(): int {

    if(!$this->checkValidEmail()) {
      return INVALID_EMAIL;
    }
    if(!$this->checkExistingEmail()) {
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

    $database = new Database();
    $database->execQuery("INSERT INTO users(Email, FirstName, LastName, Passwd) VALUES ('$this->email', '$this->firstName', '$this->lastName', '$this->password');");
    $database->disconnectFromDB();

    return SUCCESS;
  }

  /**
   * Function to check first name input
   */
  public function checkFirstName(): bool {
    if(empty($this->firstName)) {
      return false;
    }

    if(strlen($this->firstName) > 100) {
      return false;
    }

    if(!preg_match(NAMES_REGEX, $this->firstName)) {
      return false;
    }

    return true;
  }

  /**
   * Function to check last name input
   */
  public function checkLastName(): bool {
    if(empty($this->lastName)) {
      return false;
    }

    if(strlen($this->lastName) > 100) {
      return false;
    }

    if(!preg_match(NAMES_REGEX, $this->lastName)) {
      return false;
    }
    return true;
  }

  /**
   * Function to check if passwords are equal
   */
  public function checkPasswords(): bool {
    return $this->password == $this->checkPassword;
  }
}

?>