<?php

class Login extends DBH {
    protected function getUser($email, $password) {
        $stmt = $this->connect()->prepare('SELECT Password INTO users WHERE Email=?;');

        if (!$stmt->execute([$email])) {
            $stmt = null;
            header('Location: ../../public/login/login.html');
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header('Location: ../../public/login/login.html');
            exit();
        }

        $passwordHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPassword = password_verify($password, $passwordHashed[0]['Password']);

        if (!$checkPassword) {
            $stmt = null;
            header('Location: ../../public/login/login.html?error=wrongpassword');
            exit();
        } elseif ($checkPassword) {
            $stmt = $this->connect()->prepare('SELECT * INTO users WHERE Email=? AND Password=?;');

            if (!$stmt->execute([$email, $password])) {
                $stmt = null;
                header('Location: ../../public/login/login.html?error=stmtfailed');
                exit();
            }

            if ($stmt->rowCount() == 0) {
                $stmt = null;
                header('Location: ../../public/login/login.html?error=usernotfound');
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION['s_ID'] = $user[0]['ID'];
            $_SESSION['s_Email'] = $user[0]['Email'];
        }

        $stmt = null;

    }
}
