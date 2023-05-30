<?php

namespace TurboMail;

use PDO;
use PDOException;

include_once 'const/global.php';

class DataBaseHandler {
    protected function connect() {
        try {
            return new PDO(
                DATA_SOURCE_NAME,
                DATABASE_USER_NAME,
                HOST_PASSWORD
            );
        } catch (PDOException $e) {
            echo 'Error!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }
}
