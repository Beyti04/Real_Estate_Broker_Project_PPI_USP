<?php

namespace App\Controllers;

use App\Models\Neighborhood;
use Config\Database;
use PDO, PDOException;

class NeighborhoodController
{
    public static function getAllNeighborhoods(): array
    {
        $pdo = Database::getInstance();
        $neighborhoods = [];

        try {
            $stmt = $pdo->query("SELECT id, location_id,neighborhood_name FROM neighborhoods");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $neighborhoods[] = new Neighborhood($row['id'], $row['location_id'], $row['neighborhood_name']);
            }
        } catch (PDOException $e) {
            die('Error fetching neighborhoods: ' . $e->getMessage());
        }

        return $neighborhoods;
    }

    public static function getNeighborhoodById(int $id): ?Neighborhood
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, location_id,neighborhood_name FROM neighborhoods WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Neighborhood($row['id'], $row['location_id'], $row['neighborhood_name']);
            } else {
                throw new PDOException("Neighborhoods not found");
            }
        } catch (PDOException $e) {
            die('Error fetching neighborhoods: ' . $e->getMessage());
        }
    }
}
