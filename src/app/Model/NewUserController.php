<?php

namespace TurboMail\Model;

include_once 'NewUser.php';
include_once __DIR__.'/../const/global.php';

/**
 * This class represents a new user in the database. It is used to perform operations related to the sign-up query
 * sent from the UI. It can interact with the NewUser object, and it contains all the necessary methods to validate and
 * sanitize the user input before inserting it into the database.
 */
class NewUserController extends NewUser {
    /**
     * The new user's first name.
     *
     * @var string
     */
    private string $firstName;
    /**
     * The new user's last name.
     *
     * @var string
     */
    private string $lastName;
    /**
     * The new user's email address
     *
     * @var string
     */
    private string $email;
    /**
     * The new user's password
     *
     * @var string
     */
    private string $password;
    /**
     * The new user's second verification password.
     *
     * @var string
     */
    private string $passwordCheck;

    /**
     * Instantiates a new NewUser object, using all the data received from the sign-up form.
     *
     * @param  string  $firstName
     * @param  string  $lastName
     * @param  string  $email
     * @param  string  $password
     * @param  string  $passwordCheck
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $passwordCheck
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->passwordCheck = $passwordCheck;
    }

    /**
     * Calls a specific validation method for every attribute, appends an error code to an array if the verification
     * failed.
     * Returns an array of errors if at least one verification failed, a 500 error code the database insertion failed,
     * or an empty array if all went well.
     *
     * @return array
     */
    public function SignupUser(): array {
        $errors = [];

        if ($this->EmptyInput()) {
            $errors[] = 1;
        }
        if ($this->InvalidFirstName()) {
            $errors[] = 2;
        }
        if ($this->InvalidLastName()) {
            $errors[] = 3;
        }
        if ($this->InvalidEmail()) {
            $errors[] = 4;
        }
        if ($this->InvalidPassword()) {
            $errors[] = 5;
        }
        if (!$this->PasswordMatch()) {
            $errors[] = 6;
        }
        if ($this->EmailTakenCheck()) {
            $errors[] = 7;
        }

        if (count($errors) == 0) {
            $status = $this->SetUser(
                $this->firstName,
                $this->lastName,
                $this->email,
                $this->password
            );
            if ($status) {
                $errors[] = 500;
            } else {
                $errors[] = 0;
            }
        }

        return $errors;
    }


    /**
     * Checks if either of the 5 attributes is an empty string.
     * Returns 1 if at least one attribute failed the test, 0 otherwise.
     *
     * @return int
     */
    private function EmptyInput(): int {
        if (empty($this->firstName) || empty($this->lastName)
            || empty($this->email)
            || empty($this->password)
            || empty($this->passwordCheck)
        ) {
            return 1;
        }

        return 0;
    }


    /**
     * Verifies that the length of the firstName attribute is not greater than the maximum configured length in the
     * global configuration file.
     * Matches the attribute against the names regular expression to prevent unexpected characters and expressions.
     * Returns 1 if either of the tests failed, 0 otherwise.
     *
     * @return int
     */
    private function InvalidFirstName(): int {
        if (strlen($this->firstName) > MAX_FIRST_NAME_LENGTH) {
            return 1;
        }

        if (!preg_match(NAMES_REGEX, $this->firstName)) {
            return 1;
        }

        return 0;
    }

    /**
     * Verifies that the length of the lastName attribute is not greater than the maximum configured length in the
     * global configuration file.
     * Matches the attribute against the names regular expression to prevent unexpected characters and expressions.
     * Returns 1 if either of the tests failed, 0 otherwise.
     *
     * @return int
     */
    private function InvalidLastName(): int {
        if (strlen($this->lastName) > MAX_LAST_NAME_LENGTH) {
            return 1;
        }

        if (!preg_match(NAMES_REGEX, $this->firstName)) {
            return 1;
        }

        return 0;
    }

    /**
     * Matches the email attribute against the configured email regular expression to prevent an invalid email format.
     * Returns 1 if the test failed, 0 otherwise.
     *
     * @return int
     */
    private function InvalidEmail(): int {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return 1;
        }

        return 0;
    }

    /**
     * Validates the password attribute against the configured maximum and minimum password lengths in the global
     * configuration file.
     * Matches the password attribute against the password regular expression to prevent unexpected characters and
     * expressions.
     * Returns 1 if either of the tests failed, 0 otherwise.
     *
     * @return int
     */
    private function InvalidPassword(): int {
        if (strlen($this->password) < MIN_PASSWORD_LENGTH || strlen($this->password) > MAX_PASSWORD_LENGTH) {
            return 1;
        }

        if (!preg_match(PASSWORD_REGEX, $this->password)) {
            return 1;
        }

        return 0;
    }

    /**
     * Matches the two password attributes against each other to verify that they are an exact match.
     * Returns 1 if the test failed, 0 otherwise.
     *
     * @return int
     */
    private function PasswordMatch(): int {
        if ($this->password == $this->passwordCheck) {
            return 1;
        }

        return 0;
    }

    /**
     * Queries the database for a user matching a given email.
     * Returns 0 if no user with the same email was found, or 1 if the given email was already assigned.
     *
     * @return int
     */
    private function EmailTakenCheck(): int {
        if ($this->UserAlreadyExist($this->email)) {
            return 1;
        }

        return 0;
    }
}
