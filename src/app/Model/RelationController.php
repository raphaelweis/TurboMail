<?php

namespace TurboMail\Model;

include_once 'Relation.php';
include_once 'MessageController.php';

/**
 * This class represents a relation row in the database. It provides methods to manipulate, create or delete the
 * information associated with relations.
 */
class RelationController extends Relation {
    /**
     * The ID associated with the sender of the relation request
     *
     * @var int
     */
    private int $idSender;
    /**
     * The ID associated with the receiver of the relation request
     *
     * @var int
     */
    private int $idReceiver;
    /**
     * The current relation status, 0 upon object creation. An int representing a boolean
     *
     * @var int
     */
    private int $status;

    /**
     * Instantiates a new relation Object given the sender and receiver ID
     *
     * @param  int  $idSender
     * @param  int  $idReceiver
     */
    public function __construct(int $idSender, int $idReceiver) {
        $this->idSender = $idSender;
        $this->idReceiver = $idReceiver;
        $this->status = 0;
    }

    /**
     * Verifies that the current relation object doesn't already exist in the database.
     * Inserts a new relation row if it did not.
     * Returns 0 if the operation was successful, 1 otherwise.
     *
     * @return int
     */
    public function RelationExists(): int {
        if ($this->RelationAlreadyExists($this->idSender, $this->idReceiver)) {
            return 1;
        }

        if ($this->SendRelation($this->idSender, $this->idReceiver, $this->status)) {
            return 1;
        }

        return 0;
    }

    /**
     * Changes the status of a relation to the given new status using the relation ID.
     * Returns 0 if the operation was successful, 1 otherwise.
     *
     * @param $newStatus
     * @param $relationId
     *
     * @return int
     */
    public static function AcceptRelation($newStatus, $relationId): int {
        $relation = new Relation();

        return $relation->UpdateRelationStatus($newStatus, $relationId);
    }

    /**
     * Using the given relation ID, deletes all the messages in associated with this relation, before deleting the
     * actual relation row in the database.
     * Returns 0 if the operation was successful, 1 otherwise.
     *
     * @param $relationId
     *
     * @return int
     */
    public static function DeleteMessagesAndRelation($relationId): int {
        $relation = new Relation();

        if (MessageController::DeleteMessagesFromRelation($relationId)) {
            return 1;
        }
        if ($relation->DeleteRelation($relationId)) {
            return 1;
        }

        return 0;
    }
}