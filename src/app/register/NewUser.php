<?php

namespace TurboMail;

include_once '../database/DataBaseHandler.php';

class NewUser extends DataBaseHandler {
    protected function setUser($firstName, $lastName, $email, $password): void {
        $stmt = $this->connect()
            ->prepare('INSERT INTO users(FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?);');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!$stmt->execute([$firstName, $lastName, $email, $hashedPassword])) {
            $stmt = null;
            header('Location: ../public/login/login.html?error=fail');
            exit();
        }

        $stmt = null;

    }

    protected function checkUser($email) {
        $stmt = $this->connect()
            ->prepare('SELECT ID FROM users WHERE Email=?;');

        if (!$stmt->execute([$email])) {
            $stmt = null;
            header('Location: ../public/login/login.html?error=fail');
            exit();
        }

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;

    }
}
