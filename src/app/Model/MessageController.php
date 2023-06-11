<?php

namespace TurboMail\Model;

use PDO;

include_once 'Message.php';
include_once __DIR__.'/../const/global.php';

class MessageController extends Message {
    /**
     * the relation ID associated to this message
     *
     * @var int
     */
    private int $relation;
    /**
     * the sender ID associated to this message
     *
     * @var int
     */
    private int $sender;
    /**
     * the receiver ID associated to this message
     *
     * @var int
     */
    private int $receiver;
    /**
     * The content (text) associated to this message
     *
     * @var string
     */
    private string $content;
    /**
     * The date and time when this message object was instantiated. The format is Year-month-day Hour-minute-seconds
     *
     * @var string
     */
    private string $date;

    /**
     * Creates a new MessageController object. Mostly useful to insert a new message into the database
     *
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
     * Find the associated relation ID in the database using the sender ID and the receiver ID. Used when creating a new
     * message object.
     *
     * Returns the relation ID, or -1 if the request failed.
     *
     * @return int
     */
    private function findRelationId(): int {
        $statement = $this->connect()->prepare(SELECT_RELATION_QUERY);

        if (!$statement->execute([
            $this->sender, $this->receiver, $this->receiver, $this->sender,
        ])
        ) {
            $statement = null;

            return -1;
        }

        if ($statement->rowCount() == 0) {
            $statement = null;

            return -1;
        }

        $relationId = $statement->fetch(PDO::FETCH_COLUMN);
        $statement = null;

        return $relationId;
    }

    /**
     * Inserts a new row in the message table.
     * Requires a full messageController Object.
     *
     * Returns 0 if the operation was successful, or 1 in case of an error.
     *
     * @return int
     */
    public function insertIntoDB(): int {
        $statement = $this->connect()->prepare(INSERT_MESSAGE_QUERY);

        if (!$statement->execute([
            $this->relation, $this->sender, $this->receiver, $this->content,
            $this->date,
        ])
        ) {
            $statement = null;

            return 1;
        }

        $statement = null;

        return 0;
    }

    /**
     * Queries the database for all messages associated to a specified relation ID.
     *
     * Returns an array with all the found messages if the operation was successful, or an empty array in case of an
     * error.
     *
     * @param $relationId
     *
     * @return array
     */
    public static function getConversationMessages($relationId): array {
        $messageObject = new Message();
        $allMessages = $messageObject->fetchMessagesByRelationId($relationId);

        if ($allMessages === null) {
            return [];
        }

        return $allMessages;
    }

    /**
     * Deletes all messages associated to a relation ID. Should be called before deleting a relation to prevent
     * foreign key errors.
     *
     * Returns 0 if the operation was successful, or 1 in case of an error.
     *
     * @param $relationId
     *
     * @return int
     */
    public static function DeleteMessagesFromRelation($relationId): int {
        $message = new Message();

        return $message->DeleteMessagesByRelationId($relationId);
    }
}