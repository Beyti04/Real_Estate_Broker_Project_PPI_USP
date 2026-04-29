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
            $stmt = $pdo->query("SELECT id, username, email, password, user_type_id, phone, image, description FROM users");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    $row['id'],
                    $row['username'],
                    $row['email'],
                    $row['password'],
                    $row['user_type_id'],
                    $row['phone'] ?? '-',
                    $row['image'] ?? '-',
                    $row['description'] ?? '-'
                );
            }
        } catch (PDOException $e) {
            die('Error fetching users: ' . $e->getMessage());
        }

        return $users;
    }
    
    public static function getUserWithoutAdmin(): array
    {
        $pdo = Database::getInstance();
        $users = [];

        try {
            $stmt = $pdo->query("SELECT id, username, email, password, user_type_id, phone, image, description FROM users WHERE user_type_id != 1");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    $row['id'],
                    $row['username'],
                    $row['email'],
                    $row['password'],
                    $row['user_type_id'],
                    $row['phone'] ?? null,
                    $row['image'] ?? null,
                    $row['description'] ?? null
                );
            }
        } catch (PDOException $e) {
            die('Error fetching users: ' . $e->getMessage());
        }

        return $users;
    }

    public static function getUserById(int $id): ?User
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, username, email, password, user_type_id, phone, image, description FROM users WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new User(
                    $row['id'],
                    $row['username'],
                    $row['email'],
                    $row['password'],
                    $row['user_type_id'],
                    $row['phone'] ?? "-",
                    $row['image'] ?? "-",
                    $row['description'] ?? "-"
                );
            } else {
                throw new PDOException("User not found");
            }
        } catch (PDOException $e) {
            die('Error fetching user: ' . $e->getMessage());
        }
    }

    public static function updateUser(int $id, string $username, string $email, int $userTypeId, string $phone, string $image, string $description): bool
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, user_type_id = :user_type_id, phone = :phone, image = :image, description = :description WHERE id = :id");
            return $stmt->execute([
                'username' => $username,
                'email' => $email,
                'user_type_id' => $userTypeId,
                'phone' => $phone ?? '-',
                'image' => $image ?? '-',
                'description' => $description ?? '-',
                'id' => $id
            ]);
        } catch (PDOException $e) {
            error_log('Error updating user: ' . $e->getMessage());
            return false;
        }
    }

    public static function updateUserProfilePassword(int $id, string $username, string $email, string $phone, string $password): bool
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, phone = :phone, password = :password WHERE id = :id");
            return $stmt->execute([
                'username' => $username,
                'email' => $email,
                'phone' => $phone ?? '-',
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'id' => $id
            ]);
        } catch (PDOException $e) {
            error_log('Error updating user profile: ' . $e->getMessage());
            return false;
        }
    }

    public static function updateUserProfile(int $id, string $username, string $email, string $phone): bool
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, phone = :phone WHERE id = :id");
            return $stmt->execute([
                'username' => $username,
                'email' => $email,
                'phone' => $phone ?? '-',
                'id' => $id
            ]);
        } catch (PDOException $e) {
            error_log('Error updating user profile: ' . $e->getMessage());
            return false;
        }
    }

    public static function deleteUser(int $id): bool
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Error deleting user: ' . $e->getMessage());
            return false;
        }
    }

    public static function updateProfile(int $id, string $username, string $email, string $newPassword = '', string $currentPassword = ''): bool
    {
        $pdo = \Config\Database::getInstance();
        
        try {
            if (!empty($newPassword)) {
                
                $user = self::getUserById($id);
                
                if (empty($currentPassword) || !password_verify($currentPassword, $user->getPassword())) {
                    return false; 
                }

                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id");
                return $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'id' => $id
                ]);
                
            } else {
                $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
                return $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'id' => $id
                ]);
            }
        } catch (\PDOException $e) {
            error_log('Error updating profile: ' . $e->getMessage());
            return false;
        }
    }
    public static function getAllAgents(): array
    {
        $pdo = Database::getInstance();
        $agents = [];

        try {
            $stmt = $pdo -> query("
            SELECT id, username, email, password, user_type_id, phone, image, description
            FROM users
            Where user_type_id = 2
            ");
            while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                $agents[] = new User(
                    $row['id'],
                    $row['username'],
                    $row['email'],
                    $row['password'],
                    $row['user_type_id'],
                    $row['phone'] ?? null,
                    $row['image'] ?? null,
                    $row['description'] ?? null
                );
            }
        } catch (PDOException $e) {
            die('Error fetching agents: '. $e->getMessage());
        }
        return $agents;
    }
    public static function getAgentById(int $id): ?User
{
    $pdo = Database::getInstance();

    try {
        $stmt = $pdo->prepare("
            SELECT id, username, email, password, user_type_id, phone, image, description
            FROM users
            WHERE id = :id AND user_type_id = 2
        ");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new User(
                $row['id'],
                $row['username'],
                $row['email'],
                $row['password'],
                $row['user_type_id'],
                $row['phone'] ?? null,
                $row['image'] ?? null,
                $row['description'] ?? null
            );
        }

        return null;
    } catch (PDOException $e) {
        die('Error fetching agent: ' . $e->getMessage());
    }
}
}

