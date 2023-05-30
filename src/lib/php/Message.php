<?php

namespace TurboMail;

include_once 'User.php';

class Message {
    private User $sender;
    private User $receiver;
    private string $content;

    public function __construct($sender, $receiver, $content) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->content = $content;
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