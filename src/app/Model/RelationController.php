<?php

namespace TurboMail\Model;

class RelationController extends Relation {
    private int $idSender;
    private int $idReceiver;
    private string $emailReceiver;
    private string $message;
    private bool $status;

    // Constructor
    public function __construct($idSender, $emailReceiver, $message) {

    }

    public function sendRelation(): bool {

        return true;
    }

    private function invalidEmail(): bool {

        return false;
    }

    private function wrongEmail(): bool {

        return false;
    }
}