<?php

namespace TurboMail;

include_once '../database/DataBaseHandler.php';
include_once '../login/UserController.php';
include_once '../../lib/php/global.php';

class NewUser extends DataBaseHandler {
    protected function setUser($firstName, $lastName, $email, $password): int {
        $statement = $this->connect()
            ->prepare(REGISTER_QUERY);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$statement->execute([
            $firstName, $lastName, $email, $hashedPassword,
        ])
        ) {
            $statement = null;
        }
        $statement = null;

        $login = new UserController($email, $password);

        return $login->loginUser();
    }

    protected function checkUser($email): bool {
        $statement = $this->connect()
            ->prepare(SELECT_USER_BY_MAIL_QUERY);

        if (!$statement->execute([$email])) {
            $statement = null;
        }

        if ($statement->rowCount() > 0) {
            return true;
        }

        return false;

    }
}
