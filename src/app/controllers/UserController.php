<?php

class UserController
{
    public $postRequest;

    public function __construct()
    {
        $postRequest = $_POST;
    }
}
