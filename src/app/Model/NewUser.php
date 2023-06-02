<?php

namespace TurboMail\Model;

include_once 'DataBaseHandler.php';
include_once 'UserController.php';
include_once __DIR__ . '/../const/global.php';

class NewUser extends DataBaseHandler {
    protected function SetUser(string $firstName, string $lastName, string $email, string $password): int {
        $statement = $this->connect()->prepare(REGISTER_QUERY);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$statement->execute([
            $firstName, $lastName, $email, $hashedPassword,
        ])
        ) {
            $statement = null;
        }
        $statement = null;

        $login = new UserController($email);
        $login->SetPassword($password);

        return $login->LoginUser();
    }

    protected function CheckUser(string $email): bool {
        $statement = $this->connect()->prepare(SELECT_USER_BY_MAIL_QUERY);

        if (!$statement->execute([$email])) {
            $statement = null;
        }

        if ($statement->rowCount() > 0) {
            return true;
        }

        return false;
    }
}
