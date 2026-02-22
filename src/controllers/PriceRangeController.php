<?php

namespace App\Controllers;

use App\Models\PriceRange;
use Config\Database;
use PDO, PDOException;

class PriceRangeController
{
    public static function getAllPriceRanges(): array
    {
        $pdo = Database::getInstance();
        $priceRanges = [];

        try {
            $stmt = $pdo->query("SELECT id, range_name,range_value FROM price_ranges");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $priceRanges[] = new PriceRange($row['id'], $row['range_name'], $row['range_value']);
            }
        } catch (PDOException $e) {
            die('Error fetching price ranges: ' . $e->getMessage());
        }

        return $priceRanges;
    }

    public static function getPriceRangeById(int $id): ?PriceRange
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, range_name,range_value FROM price_ranges WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new PriceRange($row['id'], $row['range_name'], $row['range_value']);
            } else {
                throw new PDOException("Price range not found");
            }
        } catch (PDOException $e) {
            die('Error fetching price ranges: ' . $e->getMessage());
        }
    }
}
