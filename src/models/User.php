<?php

namespace App\Models;


class User
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private int $userType;
       private string $phone;
    private string $image;
    private string $description;

    public function __construct(int $id, string $username, string $email, string $password, int $userType)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->userType = $userType;
            $this->phone = null;
        $this->image = null;
        $this->description = null;
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
     public function getPhone(): string
    {
        return $this->phone;
    }
    public function getImage(): string
    {
        return $this->image;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
}
