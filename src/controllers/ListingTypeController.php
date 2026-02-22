<?php

namespace App\Controllers;

use App\Models\ListingType;
use Config\Database;
use PDO, PDOException;

class ListingTypeController
{
    public static function getAllListingTypes(): array
    {
        $pdo = Database::getInstance();
        $listingTypes = [];

        try {
            $stmt = $pdo->query("SELECT id, type_name FROM listing_types");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $listingTypes[] = new ListingType($row['id'], $row['type_name']);
            }
        } catch (PDOException $e) {
            die('Error fetching listing types: ' . $e->getMessage());
        }

        return $listingTypes;
    }

    public static function getEstateTypeById(int $id): ?ListingType
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, type_name FROM listing_types WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new ListingType($row['id'], $row['type_name']);
            } else {
                throw new PDOException("Listing type not found");
            }
        } catch (PDOException $e) {
            die('Error fetching listing types: ' . $e->getMessage());
        }
    }
}
