<?php

namespace TurboMail;

use PDO;

include_once '../database/DataBaseHandler.php';

class User extends DataBaseHandler {
    protected function getUser($email, $password): int {

        $statement = $this->connect()->prepare('SELECT * FROM users WHERE Email=?;');
        if (!$statement->execute([$email])) {
            $statement = null;

            return 1;
        }
        if ($statement->rowCount() == 0) {
            $statement = null;

            return 1;
        }

        $user = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!password_verify($password, $user[0]['Password'])) {
            $statement = null;

            return 1;
        }

        session_start();
        $_SESSION['s_ID'] = $user[0]['ID'];
        $_SESSION['s_FirstName'] = $user[0]['FirstName'];
        $_SESSION['s_LastName'] = $user[0]['LastName'];
        $_SESSION['s_Email'] = $user[0]['Email'];

        $statement = null;

        return 0;
    }
}
