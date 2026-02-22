<?php

namespace App\Controllers;

use App\Models\EstateType;
use Config\Database;
use PDO, PDOException;

class EstateTypeController
{
    private $pdo = Database::getInstance();
    public function getAllEstateTypes(): array
    {
        $estateTypes = [];

        try {
            $stmt = $this->pdo->query("SELECT id, name FROM estate_types");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estateTypes[] = new EstateType($row['id'], $row['name']);
            }
        } catch (PDOException $e) {
            die('Error fetching estate types: ' . $e->getMessage());
        }

        return $estateTypes;
    }

    public function getEstateTypeById(int $id):?EstateType
    {
        try{
            $stmt=$this->pdo->prepare("SELECT id, name FROM estate_types WHERE id=:id");
            $stmt->execute(['id'=>$id]);
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                return new EstateType($row['id'], $row['name']);
            }
            else{
                throw new PDOException("Estate type not found");
            }
        }
        catch(PDOException $e){
            die('Error fetching estate type: ' . $e->getMessage());
        }
    }
}