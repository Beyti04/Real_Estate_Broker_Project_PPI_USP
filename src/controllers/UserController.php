<?php

namespace App\Controllers;

use App\Models\User;
use Config\Database;
use PDO, PDOException;

class UserController
{
    public static function getAllUsers(): array
    {
        $pdo = Database::getInstance();
        $users = [];

        try {
            $stmt = $pdo->query("SELECT id, username, email, password, user_type FROM users");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User($row['id'], $row['username'], $row['email'], $row['password'], $row['user_type']);
            }
        } catch (PDOException $e) {
            die('Error fetching users: ' . $e->getMessage());
        }

        return $users;
    }

    public function getUserById(int $id): ?User
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, username, email, password, user_type FROM users WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new User($row['id'], $row['username'], $row['email'], $row['password'], $row['user_type']);
            } else {
                throw new PDOException("User not found");
            }
        } catch (PDOException $e) {
            die('Error fetching user: ' . $e->getMessage());
        }
    }
}
