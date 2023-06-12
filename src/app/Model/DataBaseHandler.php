<?php

namespace TurboMail\Model;

include_once __DIR__.'/../const/global.php';

use PDO;
use PDOException;

/**
 * The DataBaseHandler class provides an abstraction to identify the objects that can interact with the database.
 */
class DataBaseHandler {
    /**
     * This method connects its caller to the configured database.
     * The database can be any type of database thanks to
     * the PDO class
     *
     * @return PDO|void
     */
    public function connect() {
        try {
            return new PDO(
                DATA_SOURCE_NAME,
                DATABASE_USER_NAME,
                HOST_PASSWORD
            );
        } catch (PDOException $e) {
            exit();
        }
    }
}
