<?php

namespace TurboMail\Model;

include_once 'Relation.php';

class RelationController extends Relation {
    private int $idSender;
    private int $idReceiver;
//    private bool $status;

    // Constructor
    public function __construct($idSender, $idReceiver) {
        $this->idSender = $idSender;
        $this->idReceiver = $idReceiver;
//        $this->status = false;
    }

    public function RelationExist(): bool {
        if($this->RelationAlreadyExist($this->idSender, $this->idReceiver)) {
            return true;
        }

        if(!$this->SendRelation($this->idSender, $this->idReceiver)) {
            return true;
        }

        return false;
    }

}