<?php

namespace App\Models;


class User{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private int $userType;

    public function __construct(int $id, string $username, string $email, string $password,int $userType)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->userType = $userType;
    }

    public function getId():int
}