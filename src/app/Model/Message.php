<?php

namespace TurboMail\Model;

use PDO;

include_once 'User.php';
include_once 'DataBaseHandler.php';


class Message extends DataBaseHandler {
    /**
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