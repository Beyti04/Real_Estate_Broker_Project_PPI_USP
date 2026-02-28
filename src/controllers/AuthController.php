<?php

namespace App\Controllers;

use App\Models\User;
use Config\Database;
use PDO, PDOException;

class AuthController {
    public static function register(string $username, string $email, string $password, int $userTypeId): bool {
        $pdo = Database::getInstance();
        
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, user_type_id) VALUES (:username, :email, :password, :user_type_id)");
            return $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPass,
                'user_type_id' => $userTypeId
            ]);
        } catch (PDOException $e) {
            error_log('Error registering user: ' . $e->getMessage());
            return false;
        }
    }

    public static function login(string $email, string $password): ?User {
        $pdo = Database::getInstance();
        
        try {
            $stmt = $pdo->prepare("SELECT id, username, email, password, user_type_id FROM users WHERE email=:email");
            $stmt->execute(['email' => $email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_type_id'] = $row['user_type_id'];

                return new User($row['id'], $row['username'], $row['email'], $row['password'], $row['user_type_id']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log('Error logging in: ' . $e->getMessage());
            return null;
        }
    }

    public static function logout(): void {
        session_unset();
        session_destroy();
    }
}