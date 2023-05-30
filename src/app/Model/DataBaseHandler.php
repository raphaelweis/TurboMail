<?php

namespace TurboMail\Model;

include_once __DIR__ . '/../const/global.php';

use PDO;
use PDOException;

class DataBaseHandler {
    protected function connect() {
        try {
            return new PDO(
                DATA_SOURCE_NAME,
                DATABASE_USER_NAME,
                HOST_PASSWORD
            );
        } catch (PDOException $e) {
            echo 'Error!: '.$e->getMessage().'<br/>';
            die();
        }
    }
}
