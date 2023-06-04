<?php

namespace TurboMail\Model;

include_once 'User.php';
include_once 'DataBaseHandler.php';

class Message extends DataBaseHandler {
    /**
     * @var User
     */
    private User $sender;
    /**
     * @var User
     */
    private User $receiver;
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
    }

    public function insertIntoDB(): int {
        $statement = $this->connect()->prepare(INSERT_MESSAGE_QUERY);

        if (!$statement->execute([$this->sender, $this->receiver, $this->content, $this->date])) {
            $statement = null;
            return 1;
        }

        $statement = null;
        return 0;
    }

    /**
     * @return User
     */
    public function getSender(): User {
        return $this->sender;
    }

    /**
     * @return User
     */
    public function getReceiver(): User {
        return $this->receiver;
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }
}