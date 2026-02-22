<?php

namespace App\Models;


class User{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private int $user_type;

    public function __construct(int $id, string $username, string $email, string $password,int $user_type)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->user_type = $user_type;
    }
}