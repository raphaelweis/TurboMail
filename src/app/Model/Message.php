<?php

namespace TurboMail\Model;

use PDO;

include_once 'User.php';
include_once 'DataBaseHandler.php';


/**
 * This class provides methods to perform operations on the message table of the database.
 * It should not be instantiated by something other than the message controller, hence the empty protected constructor.
 */
class Message extends DataBaseHandler {
    protected function __construct() {
        // empty constructor.
    }

    /**
     * Fetches all messages in the database given a relation ID.
     *
     * Returns an array containing the fetched messages if the operation was successful, or null in case of an error.
     *
     * @param $relationId
     *
     * @return array|null
     */
    protected function fetchMessagesByRelationId($relationId): ?array {
        $statement = $this->connect()->prepare(SELECT_MESSAGES_BY_RELATION_QUERY);

        if (!$statement->execute([$relationId])) {
            $statement = null;

            return null;
        }

        if ($statement->rowCount() === 0) {
            $statement = null;

            return null;
        }

        $messagesArray = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement = null;

        return $messagesArray;
    }

    /**
     *
     * Deletes all messages associated to a relation ID. Should be called before deleting a relation to prevent
     * foreign key errors.
     *
     * Returns 0 if the operation was successful, or 1 in case of an error.
     *
     * @param $relationId
     *
     * @return int
     */
    protected function DeleteMessagesByRelationId($relationId): int {
        $statement = $this->connect()->prepare(DELETE_MESSAGES_BY_RELATION_QUERY);

        if (!$statement->execute([$relationId])) {
            $statement = null;

            return 1;
        }

        $statement = null;

        return 0;
    }
}