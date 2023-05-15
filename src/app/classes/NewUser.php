<?php

namespace app\classes;

const NAMES_REGEX = "/^(?!\s)[a-zA-Z\'\-\sÀ-ÖØ-öø-ÿ]+$/u";

$nu = new NewUser(
    'sam.barthazon@gmail.com',
    'Sam',
    'BARTHAZON',
    'password',
    'password'
);

class NewUser extends User {
    //
    // Properties
    //
    private $firstName;
    private $lastName;
    private $checkPassword;

    /**
     * Constructor.
     *
     * @var mixed User's email
     * @var mixed User's first name
     * @var mixed User's last name
     * @var mixed User's password
     * @var mixed User's password
     */
    public function __construct(
        $email,
        $firstName,
        $lastName,
        $password,
        $checkPassword
    ) {
        parent::__construct($email, $password);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->checkPassword = $checkPassword;

        $this->signUp();
    }

    //
    // Methods
    //

    /**
     * Sign up function
     * Check all inputs of the sign-up form
     * Return the appropriate error in case of problem.
     */
    public function signUp(): int {

        if (!$this->checkValidEmail()) {
            echo 'Email error';

            return INVALID_EMAIL;
        }
        if (!$this->checkExistingEmail()) {
            echo 'Existing email';

            return EMAIL_IN_USE;
        }

        if (!$this->checkFirstName()) {
            echo 'First name error';

            return INVALID_FIRSTNAME;
        }

        if (!$this->checkLastName()) {
            echo 'Last name error';

            return INVALID_LASTNAME;
        }

        if (!$this->checkPasswords()) {
            echo "Passwords don't match";

            return PASSWORDS_DONT_MATCH;
        }

        $db = new Database();
        $hashed = password_hash($this->password, PASSWORD_DEFAULT);

        //    $db->execQuery("INSERT INTO users(Email, Firstname, Lastname, Password) VALUES ('$this->email', '$this->firstName', '$this->lastName', '$hashed');");

        return SUCCESS;
    }

    /**
     * Function to check first name input.
     */
    public function checkFirstName(): bool {
        if (empty($this->firstName)) {
            return false;
        }

        if (strlen($this->firstName) > 100) {
            return false;
        }

        if (!preg_match(NAMES_REGEX, $this->firstName)) {
            return false;
        }

        return true;
    }

    /**
     * Function to check last name input.
     */
    public function checkLastName(): bool {
        if (empty($this->lastName)) {
            return false;
        }

        if (strlen($this->lastName) > 100) {
            return false;
        }

        if (!preg_match(NAMES_REGEX, $this->lastName)) {
            return false;
        }

        return true;
    }

    /**
     * Function to check if passwords are equal.
     */
    public function checkPasswords(): bool {
        return $this->password == $this->checkPassword;
    }
}
