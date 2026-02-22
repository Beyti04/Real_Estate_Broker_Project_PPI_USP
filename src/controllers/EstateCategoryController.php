<?php

namespace App\Controllers;

use App\Models\EstateCategory;
use Config\Database;
use PDO, PDOException;

class EstateCategoryController
{
    public static function getAllEstateCategories(): array
    {
        $pdo = Database::getInstance();
        $estateCategories = [];

        try {
            $stmt = $pdo->query("SELECT id, category_name FROM estate_categories");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estateCategories[] = new EstateCategory($row['id'], $row['category_name']);
            }
        } catch (PDOException $e) {
            die('Error fetching estate categories: ' . $e->getMessage());
        }

        return $estateCategories;
    }

    public static function getEstateCategoryById(int $id): ?EstateCategory
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, category_name FROM estate_categories WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new EstateCategory($row['id'], $row['category_name']);
            } else {
                throw new PDOException("Estate category not found");
            }
        } catch (PDOException $e) {
            die('Error fetching estate category: ' . $e->getMessage());
        }
    }
}
