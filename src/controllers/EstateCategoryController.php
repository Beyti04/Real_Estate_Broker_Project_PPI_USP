<?php

namespace App\Controllers;

use App\Models\EstateCategory;
use Config\Database;
use PDO, PDOException;

class EstateCategoryController
{
    private $pdo = Database::getInstance();
    public function getAllEstateCategories(): array
    {
        $estateCategories = [];

        try {
            $stmt = $this->pdo->query("SELECT id, name FROM estate_categories");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estateCategories[] = new EstateCategory($row['id'], $row['name']);
            }
        } catch (PDOException $e) {
            die('Error fetching estate categories: ' . $e->getMessage());
        }

        return $estateCategories;
    }

    public function getEstateCategoryById(int $id):?EstateCategory
    {
        try{
            $stmt=$this->pdo->prepare("SELECT id, name FROM estate_categories WHERE id=:id");
            $stmt->execute(['id'=>$id]);
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                return new EstateCategory($row['id'], $row['name']);
            }
            else{
                throw new PDOException("Estate category not found");
            }
        }
        catch(PDOException $e){
            die('Error fetching estate category: ' . $e->getMessage());
        }
    }
}