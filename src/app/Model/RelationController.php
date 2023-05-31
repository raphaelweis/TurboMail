<?php

namespace TurboMail\Model;

class RelationController extends Relation {
    private int $idSender;
    private int $idReceiver;
    private string $message;

    // Constructor
    public function __construct($idSender, $idReceiver, $message) {
        $this->idSender = $idSender;
        $this->idReceiver = $idReceiver;
        $this->message = $message;
    }
}