<?php

namespace TurboMail\Model;

include_once 'Relation.php';

class RelationController extends Relation {
    private int $idSender;
    private int $idReceiver;
    private int $status;

    // Constructor
    public function __construct(int $idSender, int $idReceiver) {
        $this->idSender = $idSender;
        $this->idReceiver = $idReceiver;
        $this->status = 0;
    }

    public function RelationExist(): bool {
        if($this->RelationAlreadyExist($this->idSender, $this->idReceiver)) {
            return true;
        }

        if(!$this->SendRelation($this->idSender, $this->idReceiver, $this->status)) {
            return true;
        }

        return false;
    }

}