<?php

namespace TurboMail\Model;

use PDO;

class Relation {

    protected function RelationAlreadyExist(int $idSender, int $idReceiver): bool {
        $dataBaseHandler = new DataBaseHandler();

        $statement = $dataBaseHandler->connect()->prepare(SELECT_RELATION_QUERY);
        if (!$statement->execute([$idSender, $idReceiver, $idReceiver, $idSender])) {
            $statement = null;

            return true;
        }
        if ($statement->rowCount() > 0) {
            $statement = null;

            return true;
        }

        $statement = null;

        return false;
    }

    protected function SendRelation(int $idSender, int $idReceiver, bool $status): bool {
        $dataBaseHandler = new DataBaseHandler();

        $statement = $dataBaseHandler->connect()->prepare(SEND_RELATION_QUERY);
        echo SEND_RELATION_QUERY;
        echo REGISTER_QUERY;
//        if (!$statement->execute([$idSender, $idReceiver, $status])) {
//            $statement = null;
//
//            return false;
//        }

        $statement = null;

        return true;
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