<?php

namespace TurboMail\Model;

use PDO;

include_once 'DataBaseHandler.php';

/**
 * This class provides methods to perform operations on the relation table of the database.
 * It should not be instantiated by something other than the relation controller, hence the empty protected constructor.
 */
class Relation extends DataBaseHandler {
    /**
     * Protected constructor - creates a new Relation object.
     */
    protected function __construct() {
        // empty constructor.
    }

    /**
     * Checks the database for an existing relation associated with the given sender and receiver.
     * Returns 0 if no existing relation was found, -1 if the query failed, or 1 if an existing relation was found.
     *
     * @param  int  $idSender
     * @param  int  $idReceiver
     *
     * @return int
     */
    protected function RelationAlreadyExists(int $idSender, int $idReceiver): int {
        $statement = $this->connect()->prepare(SELECT_RELATION_QUERY);

        if (!$statement->execute([$idSender, $idReceiver, $idReceiver, $idSender])) {
            $statement = null;

            return -1;
        }
        if ($statement->rowCount() > 0) {
            $statement = null;

            return 1;
        }

        $statement = null;

        return 0;
    }

    /**
     * Creates a new relation row in the database, given the necessary information.
     * Returns 0 if the operation was successful, 1 otherwise.
     *
     * @param  int  $idSender
     * @param  int  $idReceiver
     * @param  int  $status
     *
     * @return int
     */
    protected function SendRelation(int $idSender, int $idReceiver, int $status): int {
        $statement = $this->connect()->prepare(SEND_RELATION_QUERY);

        if (!$statement->execute([$idSender, $idReceiver, $status])) {
            $statement = null;

            return 1;
        }

        $statement = null;

        return 0;
    }

    /**
     * Changes the status column from a relation row to the given 0 or 1 value.
     * Returns 0 if the operation was successful, 1 otherwise.
     *
     * @param  int  $newStatus
     * @param  int  $relationId
     *
     * @return int
     */
    protected function UpdateRelationStatus(int $newStatus, int $relationId): int {
        $statement = $this->connect()->prepare(UPDATE_RELATION_STATUS_QUERY);

        if (!$statement->execute([$newStatus, $relationId])) {
            $statement = null;

            return 1;
        }

        $statement = null;

        return 0;
    }

    /**
     * Deletes a relation row in the database using the given relation ID.
     * Returns 0 if the operation was successful, 1 otherwise.
     *
     * @param  int  $relationId
     *
     * @return int
     */
    protected function DeleteRelation(int $relationId): int {
        $statement = $this->connect()->prepare(DELETE_RELATION_BY_ID_QUERY);

        if (!$statement->execute([$relationId])) {
            $statement = null;

            return 1;
        }

        $statement = null;

        return 0;
    }

    /**
     * Queries the database for the relation ID associated with the given sender and receiver ID in the relation table.
     * Returns the relation ID if the operation was successful, -1 otherwise.
     *
     * @param  int  $idSender
     * @param  int  $idReceiver
     *
     * @return int
     */
    public function GetRelationId(int $idSender, int $idReceiver): int {
        $statement = $this->connect()->prepare(SELECT_RELATION_QUERY);

        if (!$statement->execute([$idSender, $idReceiver, $idReceiver, $idSender,])) {
            $statement = null;

            return -1;
        }
        if ($statement->rowCount() == 0) {
            $statement = null;

            return -1;
        }

        $relation = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $relation[0][ID_RELATION_TABLE];
    }
}