<?php

namespace TurboMail\Model;

include_once 'DataBaseHandler.php';
include_once __DIR__ . '/../const/global.php';

use PDO;

class User extends DataBaseHandler {
    protected function getUser($email, $password): int {

        $statement = $this->connect()->prepare(LOGIN_QUERY);
        if (!$statement->execute([$email])) {
            $statement = null;

            return 1;
        }
        if ($statement->rowCount() == 0) {
            $statement = null;

            return 1;
        }

        $user = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!password_verify($password, $user[0][PASSWORD_USER_TABLE])) {
            $statement = null;

            return 1;
        }

        session_start();
        $_SESSION['s_ID'] = $user[0][ID_USER_TABLE];
        $_SESSION['s_FirstName'] = $user[0][FIRST_NAME_USER_TABLE];
        $_SESSION['s_LastName'] = $user[0][LAST_NAME_USER_TABLE];
        $_SESSION['s_Email'] = $user[0][EMAIL_USER_TABLE];

        $statement = null;

        return 0;
    }
}
