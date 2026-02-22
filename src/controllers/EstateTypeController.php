<?php

namespace App\Controllers;

use App\Models\EstateType;
use Config\Database;
use PDO, PDOException;

class EstateTypeController
{
    public static function getAllEstateTypes(): array
    {
        $pdo = Database::getInstance();
        $estateTypes = [];

        try {
            $stmt = $pdo->query("SELECT id, type_name, category_id FROM estate_types");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estateTypes[] = new EstateType($row['id'], $row['type_name'], $row['category_id']);
            }
        } catch (PDOException $e) {
            die('Error fetching estate types: ' . $e->getMessage());
        }

        return $estateTypes;
    }

    public static function getEstateTypeById(int $id): ?EstateType
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, type_name, category_id FROM estate_types WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new EstateType($row['id'], $row['type_name'], $row['category_id']);
            } else {
                throw new PDOException("Estate type not found");
            }
        } catch (PDOException $e) {
            die('Error fetching estate type: ' . $e->getMessage());
        }
    }
}
