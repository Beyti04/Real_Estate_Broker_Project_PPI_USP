<?php

namespace App\Controllers;

use App\Models\Region;
use Config\Database;
use PDO, PDOException;

class RegionController
{
    private $pdo = Database::getInstance();
    public function getAllRegions(): array
    {
        $regions = [];

        try {
            $stmt = $this->pdo->query("SELECT id, name FROM regions");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $regions[] = new Region($row['id'], $row['name']);
            }
        } catch (PDOException $e) {
            die('Error fetching regions: ' . $e->getMessage());
        }

        return $regions;
    }

    public function getRegionById(int $id):?Region
    {
        try{
            $stmt=$this->pdo->prepare("SELECT id, name FROM regions WHERE id=:id");
            $stmt->execute(['id'=>$id]);
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                return new Region($row['id'], $row['name']);
            }
            else{
                throw new PDOException("Region not found");
            }
        }
        catch(PDOException $e){
            die('Error fetching region: ' . $e->getMessage());
        }
    }
}