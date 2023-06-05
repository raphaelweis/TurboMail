<?php

namespace TurboMail\Model;

use PDO;

class Relation {
    protected function RelationAlreadyExists(int $idSender, int $idReceiver): int {
        $dataBaseHandler = new DataBaseHandler();

        $statement = $dataBaseHandler->connect()->prepare(SELECT_RELATION_QUERY);
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

    protected function SendRelation(int $idSender, int $idReceiver, int $status): int {
        $dataBaseHandler = new DataBaseHandler();

        $statement = $dataBaseHandler->connect()->prepare(SEND_RELATION_QUERY);
        if(!$statement->execute([$idSender, $idReceiver, $status])) {
            $statement = null;

            return 0;
        }

        $statement = null;
        return 1;
    }

    public function AcceptRelation(int $newStatus, int $relationId) {
        $databaseHandler = new DataBaseHandler();

        $statement = $databaseHandler->connect()->prepare(UPDATE_RELATION_STATUS_QUERY);
        if (!$statement->execute([$newStatus, $relationId])) {
            $statement = null;

            return 1;
        }

        $statement = null;
        return 0;
    }

    public function GetRelationId(int $idSender, int $idReceiver): int {
        $dataBaseHandler = new DataBaseHandler();

        $statement = $dataBaseHandler->connect()->prepare(SELECT_RELATION_QUERY);
        if (!$statement->execute([$idSender, $idReceiver, $idReceiver, $idSender])) {
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