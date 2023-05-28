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
            header('Location: ../public/login/login.html?error=fail');
            exit();
        }

        $statement = null;

    }

    protected function checkUser($email) {
        $statement = $this->connect()
            ->prepare('SELECT ID FROM users WHERE Email=?;');

        if (!$statement->execute([$email])) {
            $statement = null;
            header('Location: ../public/login/login.html?error=fail');
            exit();
        }

        if ($statement->rowCount() > 0) {
            return true;
        }

        return false;

    }
}
