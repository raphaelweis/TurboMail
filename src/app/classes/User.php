<?php

require_once "ErrorCodes.php";

const EMAIL_REGEX = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
const PASSWORD_REGEX = "/^[a-zA-Z0-9\/!@#$%&*]+$/"; // To change to don't accept ' " and spaces

class User
{
    /*
    * Properties
    */
    protected $email;
    protected $password;

    /**
     * Constructor
     *
     * @param mixed $email User's email
     * @param mixed $password User's password
     */
    public function __construct($email, $password)
    {
        $this->email = trim(htmlspecialchars($email));
        $this->password = trim(htmlspecialchars($password));
    }


    /*
    * Methods
    */

    /**
     * Sign in function
     * Check all inputs of the sign in form
     * Return the appropriate error in case of problem
     */
    public function signIn(): int
    {
        if (!$this->checkValidEmail()) {
            return INVALID_EMAIL;
        }
        if (!$this->checkValidPassword()) {
            return INVALID_PASSWORD;
        }

        // Check email and password associated with
        if (!$this->checkExistingEmail()) {
            return EMAIL_NOT_FOUND;
        }

        $this->success();

        return SUCCESS;
    }

    /**
     * After all checks, the user can log in
     */
    public function success()
    {
        $db = new Database();
        $result = $db->execStandardQuery("*", "users", "Email = '$this->email'");
        if ($result) {
            if (mysqli_num_rows($result) != 0) {
                $row = mysqli_fetch_assoc($result);
                if ($this->checkGoodPassword($row)) {
                    $this->activeSession();

                    header('Location: index.html');
                    exit();
                }
            }
        }
    }

    /**
     * Active session while logged in
     */
    public function activeSession()
    {

    }

    /**
     * Function to check the user's email syntax
     * @return bool
     */
    public function checkValidEmail(): bool
    {
        if (empty($this->email)) {
            return false;
        }

        if (!preg_match(EMAIL_REGEX, $this->email)) {
            return false;
        }

        return true;
    }

    /**
     * Function to search the user's email in the database
     */
    public function checkExistingEmail(): bool
    {
        $db = new Database();
        if (!$db->execStandardQuery("*", "users", "Email = '$this->email'")) {
            return false;
        }
        return true;
    }

    /**
     * Function to check the user's password syntax
     */
    public function checkValidPassword(): bool
    {
        if (strlen($this->password) < 8) {
            return false;
        }

        if (strlen($this->password) > 256) {
            return false;
        }

        if (!preg_match(PASSWORD_REGEX, $this->password)) {
            return false;
        }

        return true;
    }

    /**
     * Function to check if the user's password is in the database
     * @param mixed $row Rows of the result of the query
     */
    public function checkGoodPassword($row): bool
    {
        return password_verify($this->password, $row['Password']);
    }
}