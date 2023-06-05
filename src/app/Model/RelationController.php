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

    public function RelationExists(): int {
        if($this->RelationAlreadyExists($this->idSender, $this->idReceiver)) {
            return 1;
        }

        if(!$this->SendRelation($this->idSender, $this->idReceiver, $this->status)) {
            return 1;
        }

        return 0;
    }
}