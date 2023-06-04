<?php

namespace TurboMail\Model;

use PDO;

include_once 'User.php';
include_once 'RelationController.php';
include_once __DIR__ . '/../const/global.php';

class UserController extends User {
    /**
     * @var string
     */
    private string $email;
    /**
     * @var string
     */
    private string $password;

    /**
     * @param string $email
     */
    public function __construct(string $email) {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function LoginUser(): int {
        if ($this->EmptyInput()) {
            return 1;
        }
        if ($this->InvalidEmail()) {
            return 1;
        }
        if ($this->InvalidPassword()) {
            return 1;
        }

        return $this->GetUser($this->email, $this->password);
    }

    private function EmptyInput(): int {
        if (empty($this->email) || empty($this->password)) {
            return 1;
        }

        return 0;
    }

    private function InvalidEmail(): int {

        $email = match (func_num_args()) {
            1 => func_get_arg(0),
            default => $this->email,
        };

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 1;
        }

        if(strlen($email) > MAX_EMAIL_LENGTH) {
            return 1;
        }

        return 0;
    }

    private function InvalidPassword(): int {
        if (!preg_match(PASSWORD_REGEX, $this->password)) {
            return 1;
        }

        if (strlen($this->password) < MIN_PASSWORD_LENGTH || strlen($this->password) > MAX_PASSWORD_LENGTH) {
            return 1;
        }

        return 0;
    }

    /**
     * @param int $idSender
     * @param string $emailReceiver
     * @param string $message
     * @return string
     */
    public function AddFriend(int $idSender, string $emailReceiver, string $message): string {
        $errors = [];

        if(empty($emailReceiver) || empty($message)) {
            $errors[] = 1;
        }
        if($this->InvalidEmail($emailReceiver)) {
            $errors[] = 2;
        }
        if(count($errors) > 0) {
            return json_encode($errors);
        }

        $idReceiver = $this->GetUserIdByEmail($emailReceiver);
        if($idReceiver == -1) {
            $errors[] = 3;
        }
        if($idSender == $idReceiver) {
            $errors[] = 4;
        }
        if(count($errors) > 0) {
            return json_encode($errors);
        }

        $newRelation = new RelationController($idSender, $idReceiver);

        if($newRelation->RelationExist()) {
            $errors[] = 5;
        }

        $idRelation = $newRelation->GetRelationId($idSender, $idReceiver);
        if($idRelation == -1) {
            $errors[] = 6;
        }

        if(count($errors) == 0) {
            //$newMessage = new Message($idSender, $idReceiver, $idRelation, $message);

            $errors[] = 0;
        }

        return json_encode($errors);
    }

    /**
     * @param int $idUser
     * @return array
     */
    public function FetchRelations(int $idUser): array {
        $statement = $this->connect()->prepare(SELECT_USER_RELATIONS_QUERY);

        if (!$statement->execute([$idUser, $idUser])) {
            $statement = null;
            return -1;
        }

        $relation = $statement->fetchAll(PDO::FETCH_ASSOC);

        $statement = null;
        return $relation;
    }

    /**
     * @param string $password
     * @return void
     */
    public function SetPassword(string $password): void {
        $this->password = $password;
    }
}
