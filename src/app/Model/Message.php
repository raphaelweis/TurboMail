<?php

namespace TurboMail\Model;

use PDO;

include_once 'User.php';
include_once 'DataBaseHandler.php';


class Message extends DataBaseHandler {
    public function fetchMessagesByRelationId($relationId): ?array {
        $statement = $this->connect()->prepare(SELECT_MESSAGES_BY_RELATION_QUERY);

        if (!$statement->execute([$relationId])) {
            $statement = null;
            return null;
        }

        if ($statement->rowCount() == 0) {
            $statement = null;
            return null;
        }

        $messageTable = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement = null;
        return $messageTable;
    }
}