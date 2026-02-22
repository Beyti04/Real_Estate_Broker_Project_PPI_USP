<?php

namespace App\Controllers;

use App\Models\UserType;
use Config\Database;
use PDO, PDOException;

class UserTypeController{
    private $pdo = Database::getInstance();
    public function getAllUserTypes(): array
    {
        $userTypes = [];

        try {
            $stmt = $this->pdo->query("SELECT id, type_name FROM user_types");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $userTypes[] = new UserType($row['id'], $row['type_name']);
            }
        } catch (PDOException $e) {
            die('Error fetching user types: ' . $e->getMessage());
        }

        return $userTypes;
    }

    public function getUserTypeById(int $id):?UserType
    {
        try{
            $stmt=$this->pdo->prepare("SELECT id, type_name FROM user_types WHERE id=:id");
            $stmt->execute(['id'=>$id]);
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                return new UserType($row['id'], $row['type_name']);
            }
            else{
                throw new PDOException("User type not found");
            }
        }
        catch(PDOException $e){
            die('Error fetching user type: ' . $e->getMessage());
        }
    }
}