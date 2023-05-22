<?php

namespace TurboMail;

include_once '../database/DataBaseHandler.php';

class User extends DataBaseHandler {
    protected function getUser($email, $password) {
        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE Email=?;');

        if (!$stmt->execute([$email])) {
            $stmt = null;
            header('Location: ../public/login/login.html?error=stmtfailed');
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header('Location: ../public/login/login.html?error=usernotfound');
            exit();
        }

        $passwordHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify(
            $password,
            $passwordHashed[0]['Password']
        );

        if (!$checkPassword) {
            $stmt = null;
            header('Location: ../public/login/login.html?error=wrongpassword');
            exit();
        }

        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

        session_start();
        $_SESSION['s_ID'] = $user[0]['ID'];
        $_SESSION['s_FirstName'] = $user[0]['FirstName'];
        $_SESSION['s_LastName'] = $user[0]['LastName'];
        $_SESSION['s_Email'] = $user[0]['Email'];

        $stmt = null;

    }
}
