<?php

namespace App\Controllers;

use App\Models\Region;
use Config\Database;
use PDO, PDOException;

class RegionController
{
    public static function getAllRegions(): array
    {
        $pdo = Database::getInstance();
        $regions = [];

        try {
            $stmt = $pdo->query("SELECT id, region_name FROM regions");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $regions[] = new Region($row['id'], $row['region_name']);
            }
        } catch (PDOException $e) {
            die('Error fetching regions: ' . $e->getMessage());
        }

        return $regions;
    }

    public function getRegionById(int $id): ?Region
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, region_name FROM regions WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Region($row['id'], $row['region_name']);
            } else {
                throw new PDOException("Region not found");
            }
        } catch (PDOException $e) {
            die('Error fetching region: ' . $e->getMessage());
        }
    }
}
