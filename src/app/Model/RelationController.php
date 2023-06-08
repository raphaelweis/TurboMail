<?php

namespace TurboMail\Model;

include_once 'Relation.php';
include_once 'MessageController.php';

class RelationController extends Relation {
    /**
     * @var int
     */
    private int $idSender;
    /**
     * @var int
     */
    private int $idReceiver;
    /**
     * @var int
     */
    private int $status;

    // Constructor
    public function __construct(int $idSender, int $idReceiver) {
        $this->idSender = $idSender;
        $this->idReceiver = $idReceiver;
        $this->status = 0;
    }

    public function RelationExists(): int {
        if ($this->RelationAlreadyExists($this->idSender, $this->idReceiver)) {
            return 1;
        }

        if (!$this->SendRelation($this->idSender, $this->idReceiver,
            $this->status)
        ) {
            return 1;
        }

        return 0;
    }

    public static function AcceptRelation($newStatus, $relationId): int {
        $relation = new Relation();

        return $relation->UpdateRelationStatus($newStatus, $relationId);
    }

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