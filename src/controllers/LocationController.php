<?php

namespace App\Controllers;

use App\Models\Location;
use Config\Database;
use PDO, PDOException;

class LocationController
{
    public static function getAllLocations()
    {
        $pdo = Database::getInstance();
        $locations = [];

        try {
            $stmt = $pdo->query("SELECT id, region_id,location_name FROM locations");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $locations[] = new Location($row['id'], $row['region_id'], $row['location_name']);
            }
        } catch (PDOException $e) {
            die('Error fetching locations: ' . $e->getMessage());
        }

        return $locations;
    }

    public static function getLocationBtId(int $id): ?Location
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, region_id,location_name FROM locations WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Location($row['id'], $row['region_id'], $row['location_name']);
            } else {
                throw new PDOException("Location not found");
            }
        } catch (PDOException $e) {
            die('Error fetching locations: ' . $e->getMessage());
        }
    }
}
