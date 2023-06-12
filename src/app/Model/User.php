<?php

namespace TurboMail\Model;

use PDO;

include_once 'DataBaseHandler.php';
include_once __DIR__.'/../const/global.php';

/**
 * This class provides methods to interact with the user table of the database, specifically when receiving a login
 * request from a registered user. It should not be instantiated by something other than the User controller, hence the
 * empty protected constructor.
 */
class User extends DataBaseHandler {
//    /**
//     * Protected constructor - generates a new User Object.
//     */
//    protected function __construct() {
//        // empty constructor
//    }

    /**
     * Queries the database for a user row matching the given email and password. Starts a new user session if the
     * operation was successful, storing the newly logged-in user's information into the session.
     * Returns 0 if the operation was successful, -1 if the query failed, or 1 if no row matching the input criteria
     * was found.
     *
     * @param  string  $email
     * @param  string  $password
     *
     * @return int
     */
    protected function GetUser(string $email, string $password): int {
        $statement = $this->connect()->prepare(LOGIN_QUERY);
        if (!$statement->execute([$email])) {
            $statement = null;

            return -1;
        }
        if ($statement->rowCount() == 0) {
            $statement = null;

            return 1;
        }

        $user = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!password_verify($password, $user[0][PASSWORD_USER_TABLE])) {
            $statement = null;

            return 1;
        }

        session_start();
        $_SESSION['s_ID'] = $user[0][ID_USER_TABLE];
        $_SESSION['s_FirstName'] = $user[0][FIRST_NAME_USER_TABLE];
        $_SESSION['s_LastName'] = $user[0][LAST_NAME_USER_TABLE];
        $_SESSION['s_Email'] = $user[0][EMAIL_USER_TABLE];

        $statement = null;

        return 0;
    }

    /**
     * Queries the database for the user ID associated with the given email.
     * Returns the user's ID if the operation was successful, -1 otherwise.
     *
     * @param $email
     *
     * @return int
     */
    public function GetUserIdByEmail($email): int {

        $statement = $this->connect()->prepare(SELECT_USER_ID_BY_MAIL_QUERY);
        if (!$statement->execute([$email])) {
            $statement = null;

            return -1;
        }
        if ($statement->rowCount() == 0) {
            $statement = null;

            return -1;
        }

        $user = $statement->fetchAll(PDO::FETCH_ASSOC);

        $statement = null;

        return $user[0][ID_USER_TABLE];
    }
}
