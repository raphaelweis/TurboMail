<?php

namespace TurboMail\Model;

include_once 'Message.php';
include_once __DIR__.'/../const/global.php';

class MessageController extends Message {
    /**
     * @var int
     */
    private int $relation;
    /**
     * @var int
     */
    private int $sender;
    /**
     * @var int
     */
    private int $receiver;
    /**
     * @var string
     */
    private string $content;
    /**
     * @var string
     */
    private string $date;

    /**
     * @param $sender
     * @param $receiver
     * @param $content
     */
    public function __construct($sender, $receiver, $content) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->content = $content;
        $this->date = date('Y-m-d H:i:s');

        $this->relation = $this->findRelationId();
    }

    /**
     * @param $sender
     * @param $receiver
     *
     * @return int
     */
    public function findRelationId(): int {
        $statement = $this->connect()->prepare(SELECT_RELATION_QUERY);

        if (!$statement->execute([$this->sender, $this->receiver, $this->receiver, $this->sender])) {
            $statement = null;
            return 1;
        }

        if ($statement->rowCount() == 0) {
            $statement = null;
            return 1;
        }

        $relationId = $statement->fetch(PDO::FETCH_COLUMN);
        $statement = null;
        return $relationId;
    }

    /**
     * @return int
     */
    public function insertIntoDB():int {
        $statement = $this->connect()->prepare(INSERT_MESSAGE_QUERY);

        if (!$statement->execute([$this->relation, $this->sender, $this->receiver, $this->content, $this->date])) {
            $statement = null;
            return 1;
        }

        $statement = null;
        return 0;
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }
}