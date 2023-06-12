<?php

namespace TurboMail\Model;

use PDO;

include_once 'User.php';
include_once 'RelationController.php';
include_once 'MessageController.php';
include_once __DIR__.'/../const/global.php';

/**
 * This class represents a user in the database.
 * It is used to perform operations related to the sign-in query
 * sent from the UI.
 * It can interact with the User object, and it contains all the necessary methods to validate and
 * sanitize the user input before interacting with the database.
 */
class UserController extends User {
    /**
     * The email given by this user.
     *
     * @var string
     */
    private string $email;

    /**
     * The password given by this user.
     *
     * @var string
     */
    private string $password;

    /**
     * Instantiates a new User object using the given email.
     *
     * @param  string  $email
     */
    public function __construct(string $email) {
        $this->email = $email;
    }

    /**
     * Attempts to log in the current user.
     * Calls the necessary methods to sanitize the input before calling the
     * GetUser method to query the database and validate the log in request.
     * Returns 0 if the operation was successful, -1 if the query failed, or 1 if any of the tests failed.
     *
     * @return int
     */
    public function LoginUser(): int {
        if ($this->EmptyInput()) {
            return 1;
        }
        if ($this->InvalidEmail()) {
            return 1;
        }
        if ($this->InvalidPassword()) {
            return 1;
        }

        return $this->GetUser($this->email, $this->password);
    }

    /**
     * Tests if any of this user's attributes are empty strings.
     * Returns 0 if the tests were successful (none of the attributes were empty), or 1 if either of the tests failed.
     *
     * @return int
     */
    private function EmptyInput(): int {
        if (empty($this->email) || empty($this->password)) {
            return 1;
        }

        return 0;
    }

    /**
     * Matches this user's email against the configured email regular expression, then verifies that it's length
     * is below the configured maximum.
     * Alternatively accepts an email as an argument to use instead.
     * Returns 0 if all tests passed, and 1 otherwise.
     *
     * @return int
     */
    private function InvalidEmail(): int {
        $email = match (func_num_args()) {
            1 => func_get_arg(0),
            default => $this->email,
        };

        if (!preg_match(EMAIL_REGEX, $email)) {
            return 1;
        }

        if (strlen($this->email) > MAX_EMAIL_LENGTH) {
            return 1;
        }

        return 0;
    }

    /**
     * Matches this user's password against the configured password regular expression, then verifies that it's length
     * is between the configured minimum and maximum.
     * Returns 0 if all tests passed, and 1 otherwise.
     *
     * @return int
     */
    private function InvalidPassword(): int {
        if (!preg_match(PASSWORD_REGEX, $this->password)) {
            return 1;
        }

        if (strlen($this->password) < MIN_PASSWORD_LENGTH || strlen($this->password) > MAX_PASSWORD_LENGTH) {
            return 1;
        }

        return 0;
    }

    /**
     * Given a sender ID, an email for the receiver, and message content, attempts to create a relation between two
     * users.
     * Validates the input, inserts a new relation row, and a new message row associated with this relation.
     * Returns an array with a single 0 value if all operations were successful, or an array of error codes for each
     * failed operation.
     *
     * @param  int  $idSender
     * @param  string  $emailReceiver
     * @param  string  $message
     *
     * @return array
     */
    public function AddFriend(int $idSender, string $emailReceiver, string $message): array {
        $errors = [];

        if (empty($emailReceiver) || empty($message)) {
            $errors[] = 1;
        }
        if ($this->InvalidEmail($emailReceiver)) {
            $errors[] = 2;
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $idReceiver = $this->GetUserIdByEmail($emailReceiver);
        if ($idReceiver == -1) {
            $errors[] = 3;
        }
        if ($idSender == $idReceiver) {
            $errors[] = 4;
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $newRelation = new RelationController($idSender, $idReceiver);

        if ($newRelation->RelationExists()) {
            $errors[] = 5;
        }

        $idRelation = $newRelation->GetRelationId($idSender, $idReceiver);
        if ($idRelation == -1) {
            $errors[] = 6;
        }

        if (count($errors) == 0) {
            $newMessage = new MessageController($idSender, $idReceiver, $message);
            $newMessage->insertIntoDB();

            $errors[] = 0;
        }

        return $errors;
    }

    /**
     * Queries the database for all the relation rows where this user's ID appears as either the sender or receiver.
     * Returns the array of relation rows if the operation was successful, or a null value otherwise.
     *
     * @param  int  $idUser
     *
     * @return array|null
     */
    public function FetchRelations(int $idUser): ?array {
        $statement = $this->connect()->prepare(SELECT_USER_RELATIONS_QUERY);

        if (!$statement->execute([$idUser, $idUser, $idUser])) {
            $statement = null;

            return null;
        }

        $relation = $statement->fetchAll(PDO::FETCH_ASSOC);

        $statement = null;

        return $relation;
    }

    /**
     * Set this user's password to the given input password.
     *
     * @param  string  $password
     *
     * @return void
     */
    public function SetPassword(string $password): void {
        $this->password = $password;
    }
}
