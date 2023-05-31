<?php

namespace TurboMail\Model;

class Relation {
    private bool $status;

    protected function GetRelation() {

    }

    protected function SetRelation($idSender, $idReceiver, $message): bool {
        return true;
    }
}