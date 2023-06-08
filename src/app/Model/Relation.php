<?php

namespace TurboMail\Model;

use PDO;

include_once 'DataBaseHandler.php';

class Relation extends DataBaseHandler {
    protected function RelationAlreadyExists(
        int $idSender,
        int $idReceiver
    ): int {
        $statement = $this->connect()->prepare(SELECT_RELATION_QUERY);

        if (!$statement->execute([
            $idSender, $idReceiver, $idReceiver, $idSender,
        ])
        ) {
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

    protected function SendRelation(
        int $idSender,
        int $idReceiver,
        int $status
    ): int {
        $statement = $this->connect()->prepare(SEND_RELATION_QUERY);

        if (!$statement->execute([$idSender, $idReceiver, $status])) {
            $statement = null;

            return 0;
        }

        $statement = null;

        return 1;
    }

    protected function UpdateRelationStatus(
        int $newStatus,
        int $relationId
    ): int {
        $statement = $this->connect()->prepare(UPDATE_RELATION_STATUS_QUERY);

        if (!$statement->execute([$newStatus, $relationId])) {
            $statement = null;

            return 1;
        }

        $statement = null;

        return 0;
    }

    protected function DeleteRelation(int $relationId): int {
        $statement = $this->connect()->prepare(DELETE_RELATION_BY_ID_QUERY);

        if (!$statement->execute([$relationId])) {
            $statement = null;

            return 1;
        }

        $statement = null;
        return 0;
    }

    //TODO: change to protected method, make static method in controller
    public function GetRelationId(int $idSender, int $idReceiver): int {
        $statement = $this->connect()->prepare(SELECT_RELATION_QUERY);

        if (!$statement->execute([
            $idSender, $idReceiver, $idReceiver, $idSender,
        ])
        ) {
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