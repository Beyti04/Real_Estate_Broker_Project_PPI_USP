<?php

namespace App\Controllers;

use App\Models\Estate;
use Config\Database;
use PDO, PDOException;

class EstateController
{
    private $pdo = Database::getInstance();
    public function getAllEstates(): array
    {
        $estates = [];

        try {
            $stmt = $this->pdo->query("SELECT id, location_area_id , estate_type_id, exposure_type, rooms, description, listing_type,price,owner_id FROM estates");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estates[] = new Estate($row['id'], $row['location_area_id'], $row['estate_type_id'], $row['exposure_type'], $row['rooms'], $row['description'], $row['listing_type'], $row['price'], $row['owner_id']);
            }
        } catch (PDOException $e) {
            die('Error fetching estates: ' . $e->getMessage());
        }

        return $estates;
    }

    public function getEstateById(int $id): ?Estate
    {
        try {
            $stmt = $this->pdo->prepare("SELECT id, location_area_id, estate_type_id, exposure_type, rooms, description, listing_type, price, owner_id FROM estates WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Estate($row['id'], $row['location_area_id'], $row['estate_type_id'], $row['exposure_type'], $row['rooms'], $row['description'], $row['listing_type'], $row['price'], $row['owner_id']);
            } else {
                throw new PDOException("Estate not found");
            }
        } catch (PDOException $e) {
            die('Error fetching estate: ' . $e->getMessage());
        }
    }
}
