<?php

namespace TurboMail;

include_once '../database/DataBaseHandler.php';

class NewUser extends DataBaseHandler {
    protected function setUser($firstName, $lastName, $email, $password): void {
        $statement = $this->connect()
            ->prepare('INSERT INTO users(FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?);');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$statement->execute([$firstName, $lastName, $email, $hashedPassword])) {
            $statement = null;
        }

        $statement = null;

    }

    protected function checkUser($email) {
        $statement = $this->connect()
            ->prepare('SELECT ID FROM users WHERE Email=?;');

        if (!$statement->execute([$email])) {
            $statement = null;
        }

        if ($statement->rowCount() > 0) {
            return true;
        }

        return false;

    }
}
