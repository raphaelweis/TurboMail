<?php

namespace TurboMail\Model;

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

    /**
     * @return bool
     */
    private function EmptyInput(): bool {
        if (empty($this->email) || empty($this->password)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function InvalidEmail(): bool {

        $email = match (func_num_args()) {
            1 => func_get_arg(0),
            default => $this->email,
        };

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        if(strlen($email) > MAX_EMAIL_LENGTH) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function InvalidPassword(): bool {
        if (!preg_match(PASSWORD_REGEX, $this->password)) {
            return true;
        }

        if (strlen($this->password) < MIN_PASSWORD_LENGTH || strlen($this->password) > MAX_PASSWORD_LENGTH) {
            return true;
        }

        return false;
    }

    /**
     * @param int $idSender
     * @param string $emailReceiver
     * @param string $message
     * @return bool
     */
    public function AddFriend(int $idSender, string $emailReceiver, string $message): bool {
        if($this->InvalidEmail($emailReceiver)) {
            return false;
        }

        $idReceiver = $this->GetUserIdByEmail($emailReceiver);
        if($idReceiver == -1) {
            return false;
        }

        if($idSender == $idReceiver) {
            return false;
        }

        $newRelation = new RelationController($idSender, $idReceiver);

        if($newRelation->RelationExist()) {
            return false;
        }

        $idRelation = $newRelation->GetRelationId($idSender, $idReceiver);
        if($idRelation == -1) {
            return false;
        }

        //$newMessage = new Message($idSender, $idReceiver, $idRelation, $message);

        return true;
    }

    /**
     * @param int $idUser
     * @return array
     */
    public function GetRelation(int $idUser): array {

        return [];
    }

    /**
     * @param string $password
     * @return void
     */
    public function SetPassword(string $password): void {
        $this->password = $password;
    }
}
