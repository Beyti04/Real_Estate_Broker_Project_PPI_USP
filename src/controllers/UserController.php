<?php

namespace App\Controllers;

use App\Models\User;
use Config\Database;
use PDO, PDOException;

class UserController
{
    private $pdo = Database::getInstance();
    public function getAllUsers(): array
    {
        $users = [];

        try {
            $stmt = $this->pdo->query("SELECT id, username, email, password, user_type FROM users");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User($row['id'], $row['username'], $row['email'], $row['password'], $row['user_type']);
            }
        } catch (PDOException $e) {
            die('Error fetching users: ' . $e->getMessage());
        }

        return $users;
    }

    public function getUserById(int $id):?User
    {
        try{
            $stmt=$this->pdo->prepare("SELECT id, username, email, password, user_type FROM users WHERE id=:id");
            $stmt->execute(['id'=>$id]);
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                return new User($row['id'], $row['username'], $row['email'], $row['password'], $row['user_type']);
            }
            else{
                throw new PDOException("User not found");
            }
        }
        catch(PDOException $e){
            die('Error fetching user: ' . $e->getMessage());
        }
    }
}