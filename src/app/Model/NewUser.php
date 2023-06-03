<?php

namespace TurboMail\Model;

include_once 'DataBaseHandler.php';
include_once 'UserController.php';
include_once __DIR__ . '/../const/global.php';

class NewUser extends DataBaseHandler {
    protected function SetUser(string $firstName, string $lastName, string $email, string $password): int {
        $statement = $this->connect()->prepare(REGISTER_QUERY);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$statement->execute([$firstName, $lastName, $email, $hashedPassword])) {
            $statement = null;

            return -1;
        }
        $statement = null;

        $login = new UserController($email);
        $login->SetPassword($password);

        return $login->LoginUser();
    }

    protected function UserAlreadyExist(string $email): int {
        $statement = $this->connect()->prepare(SELECT_USER_BY_MAIL_QUERY);

        if (!$statement->execute([$email])) {
            $statement = null;

            return -1;
        }

        if ($statement->rowCount() > 0) {
            return 1;
        }

        return 0;
    }
}
