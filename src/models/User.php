<?php

namespace App\Models;


class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private int $userType;

    public function __construct(int $id, string $username, string $email, string $password, int $userType)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->userType = $userType;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }
}
