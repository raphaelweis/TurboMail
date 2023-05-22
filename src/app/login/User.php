<?php

namespace TurboMail;

use PDO;

include_once '../database/DataBaseHandler.php';

class User extends DataBaseHandler {
    protected function getUser($email, $password): int {

        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE Email=?;');
        if (!$stmt->execute([$email])) {
            $stmt = null;

            return 1;
        }
        if ($stmt->rowCount() == 0) {
            $stmt = null;

            return 1;
        }

        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!password_verify($password, $user[0]['Password'])) {
            $stmt = null;

            return 1;
        }

        session_start();
        $_SESSION['s_ID'] = $user[0]['ID'];
        $_SESSION['s_FirstName'] = $user[0]['FirstName'];
        $_SESSION['s_LastName'] = $user[0]['LastName'];
        $_SESSION['s_Email'] = $user[0]['Email'];

        $stmt = null;

        return 0;
    }
}
