<?php

namespace TurboMail\Model;

include_once 'DataBaseHandler.php';
include_once 'UserController.php';
include_once __DIR__.'/../const/global.php';

/**
 * This class provides methods to interact with the user table of the database, specifically when creating a new user
 * after a sign-up request. It should not be instantiated by something other than the NewUser controller, hence the
 * empty protected constructor.
 */
class NewUser extends DataBaseHandler {
    /**
     * Protected constructor - generates a new NewUser Object.
     */
    protected function __construct() {
        // empty constructor
    }

    /**
     * Inserts a new User row in the database and generates a password hash to keep the information secure.
     * Finally, the method calls the login method to directly log in the new user.
     * Returns 0 if the operation was successful, or 1 in case of an error.
     *
     * @param  string  $firstName
     * @param  string  $lastName
     * @param  string  $email
     * @param  string  $password
     *
     * @return int
     */
    protected function SetUser(string $firstName, string $lastName, string $email, string $password): int {
        $statement = $this->connect()->prepare(REGISTER_QUERY);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$statement->execute([$firstName, $lastName, $email, $hashedPassword])) {
            $statement = null;

            return -1;
        }
        $statement = null;

        $login = new UserController($email);
        $login->SetPassword($password);

        return $login->LoginUser();
    }

    /**
     * Queries the database for a user matching a given email.
     * Returns 0 if no user with the same email was found, -1 if the query failed to execute, or 1 if the given email
     * was already assigned.
     *
     * @param  string  $email
     *
     * @return int
     */
    protected function UserAlreadyExist(string $email): int {
        $statement = $this->connect()->prepare(SELECT_USER_BY_MAIL_QUERY);

        if (!$statement->execute([$email])) {
            $statement = null;

            return -1;
        }

        if ($statement->rowCount() > 0) {
            return 1;
        }

        return 0;
    }
}
