<?php

namespace TurboMail;

use PDO;
use PDOException;

require_once '../../lib/php/global.php';

class DataBaseHandler {
    protected function connect() {
        try {
            $dbh = new PDO(
                DATA_SOURCE_NAME,
                USER_NAME,
                HOST_PASSWORD
            );

            return $dbh;
        } catch (PDOException $e) {
            echo 'Error!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }
}
