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

    // Maybe change this function with error codes as return values
    public function RelationExist(): bool {
        if($this->CheckRelation($this->idSender, $this->idReceiver)) {
            return true;
        }

        if(!$this->SendRelation($this->idSender, $this->idReceiver, $this->message)) {
            return true;
        }

        return false;
    }

}