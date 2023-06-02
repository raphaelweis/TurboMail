<?php

namespace TurboMail\Model;

class Relation {
    private bool $status;

    protected function GetRelation() {

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