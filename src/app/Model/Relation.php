<?php

namespace TurboMail\Model;

class Relation {
    private bool $status;

    protected function CheckRelation(int $idSender, int $idReceiver): bool {
        $dataBaseHandler = new DataBaseHandler();

        $statement = $dataBaseHandler->connect()->prepare(SELECT_RELATION_QUERY);
        if (!$statement->execute([$idSender, $idReceiver])) {
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

    protected function SendRelation($idSender, $idReceiver, $message): bool {
        $dataBaseHandler = new DataBaseHandler();

        $statement = $dataBaseHandler->connect()->prepare(SEND_RELATION_QUERY);

        if (!$statement->execute([$idSender, $idReceiver, $message])) {
            $statement = null;

            return false;
        }

        $statement = null;

        return true;
    }
}