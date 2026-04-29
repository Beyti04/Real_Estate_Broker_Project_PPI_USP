<?php

namespace App\Controllers;

use App\Models\Estate;
use App\Models\ExposureType;
use Config\Database;
use PDO, PDOException;

class EstateController
{
    public static function getAllEstates(): array
    {
        $db = Database::getInstance();

        $query = "
            SELECT
                e.id,
                c.city_name_bg AS city_name,
                n.neighborhood_name_bg AS neighborhood_name,
                e.estate_address,
                et.type_name AS estate_type,
                e.rooms, e.area, e.floor,
                e.exposure_type,
                e.description,
                lt.type_name AS listing_type,
                e.price,
                u.username AS owner_name,
                e.creation_date,
                e.expiration_date,
                s.status_name,(
            SELECT ei.image_path
            FROM estate_images ei
            WHERE ei.estate_id = e.id
            AND ei.is_primary = 1
            LIMIT 1
        ) AS primary_image
            FROM estates e
            LEFT JOIN cities c ON e.city_id=c.id
            LEFT JOIN neighborhoods n ON e.neighborhood_id=n.id
            LEFT JOIN estate_types et ON e.estate_type_id=et.id
            LEFT JOIN listing_types lt ON e.listing_type_id=lt.id
            LEFT JOIN users u ON e.owner_id=u.id
            LEFT JOIN estate_status s ON e.status_id=s.id
        ";
        
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getEstateById(int $id): ?Estate
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT * FROM estates WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Estate(
                    $row['id'], 
                    $row['city_id'], 
                    $row['neighborhood_id'], 
                    $row['estate_address'], 
                    $row['estate_type_id'], 
                    $row['rooms'], 
                    $row['floor'], 
                    $row['area'],
                    ExposureType::from($row['exposure_type']), 
                    $row['description'], 
                    $row['listing_type_id'], 
                    $row['price'], 
                    $row['owner_id'], 
                    $row['creation_date'], 
                    $row['expiration_date'], 
                    $row['status_id']
                );
            } else {
                return null;
            }
        } catch (PDOException $e) {
            die('Error fetching estate: ' . $e->getMessage());
        }
    }
    
    public static function createEstate(
        int $cityId, int $neighborhoodId, string $address, 
        int $estateTypeId, string $exposureType, int $rooms, int $floor,
        string $description, int $listingTypeId, float $price, int $ownerId, int $statusId
    ): bool {
        $pdo = Database::getInstance();
        
        $creationDate = date('Y-m-d');
        $expirationDate = date('Y-m-d', strtotime('+30 days'));

        try {
            $stmt = $pdo->prepare("
                INSERT INTO estates 
                (city_id, neighborhood_id, estate_address, estate_type_id, exposure_type, rooms, floor, description, listing_type_id, price, owner_id, creation_date, expiration_date, status_id) 
                VALUES 
                (:city_id, :neighborhood_id, :address, :estate_type_id, :exposure_type, :rooms, :floor, :description, :listing_type_id, :price, :owner_id, :creation_date, :expiration_date, :status_id)
            ");
            
            return $stmt->execute([
                'city_id' => $cityId,
                'neighborhood_id' => $neighborhoodId,
                'address' => $address,
                'estate_type_id' => $estateTypeId,
                'exposure_type' => $exposureType,
                'rooms' => $rooms,
                'floor' => $floor,
                'description' => $description,
                'listing_type_id' => $listingTypeId,
                'price' => $price,
                'owner_id' => $ownerId,
                'creation_date' => $creationDate,
                'expiration_date' => $expirationDate,
                'status_id' => $statusId
            ]);
        } catch (\PDOException $e) {
            error_log('Error creating estate: ' . $e->getMessage());
            return false;
        }
    }

    public static function deleteEstate(int $id): bool
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("DELETE FROM estates WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Error deleting estate: ' . $e->getMessage());
            return false;
        }
    }

    public static function updateEstate(
        int $id, int $cityId, int $neighborhoodId, string $address, 
        int $estateTypeId, string $exposureType, int $rooms, int $floor,
        string $description, int $listingTypeId, float $price, int $ownerId, int $statusId
    ): bool {
        $pdo = Database::getInstance();
        
        try {
            $stmt = $pdo->prepare("
                UPDATE estates SET 
                city_id = :city_id,
                neighborhood_id = :neighborhood_id,
                estate_address = :address,
                estate_type_id = :estate_type_id,
                exposure_type = :exposure_type,
                rooms = :rooms,
                floor = :floor,
                description = :description,
                listing_type_id = :listing_type_id,
                price = :price,
                owner_id = :owner_id,
                status_id = :status_id
                WHERE id = :id
            ");
            
            return $stmt->execute([
                'id' => $id,
                'city_id' => $cityId,
                'neighborhood_id' => $neighborhoodId,
                'address' => $address,
                'estate_type_id' => $estateTypeId,
                'exposure_type' => $exposureType,
                'rooms' => $rooms,
                'floor' => $floor,
                'description' => $description,
                'listing_type_id' => $listingTypeId,
                'price' => $price,
                'owner_id' => $ownerId,
                'status_id' => $statusId
            ]);
        } catch (\PDOException $e) {
            error_log('Error updating estate: ' . $e->getMessage());
            return false;
        }
    }
    public static function createEstateWithImages(
    int $cityId,
    int $neighborhoodId,
    string $address,
    int $estateTypeId,
    string $exposureType,
    int $rooms,
    int $floor,
    float $area,
    string $description,
    int $listingTypeId,
    float $price,
    int $ownerId,
    int $statusId,
    array $images
    ): bool {
    $pdo = Database::getInstance();

    $creationDate = date('Y-m-d');
    $expirationDate = date('Y-m-d', strtotime('+30 days'));

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("
            INSERT INTO estates
            (city_id, neighborhood_id, estate_address, estate_type_id, rooms, area, floor, exposure_type, description, listing_type_id, price, owner_id, creation_date, expiration_date, status_id)
            VALUES
            (:city_id, :neighborhood_id, :address, :estate_type_id, :rooms, :area, :floor, :exposure_type, :description, :listing_type_id, :price, :owner_id, :creation_date, :expiration_date, :status_id)
        ");

        $stmt->execute([
            'city_id' => $cityId,
            'neighborhood_id' => $neighborhoodId,
            'address' => $address,
            'estate_type_id' => $estateTypeId,
            'rooms' => $rooms,
            'area' => $area,
            'floor' => $floor,
            'exposure_type' => $exposureType,
            'description' => $description,
            'listing_type_id' => $listingTypeId,
            'price' => $price,
            'owner_id' => $ownerId,
            'creation_date' => $creationDate,
            'expiration_date' => $expirationDate,
            'status_id' => $statusId
        ]);

        $estateId = (int)$pdo->lastInsertId();

        $uploadDir = __DIR__ . '/../../public/uploads/estates/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $insertImageStmt = $pdo->prepare("
            INSERT INTO estate_images (estate_id, is_primary, image_path)
            VALUES (:estate_id, :is_primary, :image_path)
        ");

        $hasUploadedAtLeastOne = false;

        foreach ($images['name'] as $index => $originalName) {
            if (empty($originalName)) {
                continue;
            }

            $tmpName = $images['tmp_name'][$index];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $safeFileName = uniqid('estate_', true) . '.' . $extension;
            $targetPath = $uploadDir . $safeFileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $relativePath = 'uploads/estates/' . $safeFileName;

                $insertImageStmt->execute([
                    'estate_id' => $estateId,
                    'is_primary' => $hasUploadedAtLeastOne ? 0 : 1,
                    'image_path' => $relativePath
                ]);

                $hasUploadedAtLeastOne = true;
            }
        }

        if (!$hasUploadedAtLeastOne) {
            $pdo->rollBack();
            return false;
        }

        $pdo->commit();
        return true;

    } catch (\PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Error creating estate with images: ' . $e->getMessage());
        return false;
    }
    }

    public static function getImagesByEstateId(int $id){
        
    }

    public static function getFilteredEstates(array $filters): array
    {
        $db = Database::getInstance();
        
        // Базовата заявка (същата като в getAllEstates, но добавяме WHERE 1=1 за лесно закачане на условия)
        $query = "
            SELECT
                e.id,
                c.city_name_bg AS city_name,
                n.neighborhood_name_bg AS neighborhood_name,
                e.estate_address,
                et.type_name AS estate_type,
                e.rooms, e.area, e.floor,
                e.exposure_type,
                e.description,
                lt.type_name AS listing_type,
                e.price,
                u.username AS owner_name,
                e.creation_date,
                e.expiration_date,
                s.status_name,
                (
                    SELECT ei.image_path
                    FROM estate_images ei
                    WHERE ei.estate_id = e.id
                    AND ei.is_primary = 1
                    LIMIT 1
                ) AS primary_image
            FROM estates e
            LEFT JOIN cities c ON e.city_id=c.id
            LEFT JOIN neighborhoods n ON e.neighborhood_id=n.id
            LEFT JOIN estate_types et ON e.estate_type_id=et.id
            LEFT JOIN listing_types lt ON e.listing_type_id=lt.id
            LEFT JOIN users u ON e.owner_id=u.id
            LEFT JOIN estate_status s ON e.status_id=s.id
            WHERE 1=1
        ";

        $params = [];

        // Динамично добавяне на филтри
        if (!empty($filters['city']) && $filters['city'] !== 'any') {
            $query .= " AND e.city_id = :city";
            $params['city'] = $filters['city'];
        }

        if (!empty($filters['neighborhood']) && $filters['neighborhood'] !== 'any') {
            $query .= " AND e.neighborhood_id = :neighborhood";
            $params['neighborhood'] = $filters['neighborhood'];
        }

        if (!empty($filters['listing_type']) && $filters['listing_type'] !== 'any') {
            $query .= " AND e.listing_type_id = :listing_type";
            $params['listing_type'] = $filters['listing_type'];
        }

        if (!empty($filters['category']) && $filters['category'] !== 'any') {
            // Предполагам, че имаш category_id в estates или estate_types.
            // Ако е в estate_types, заявката ще изглежда така:
            $query .= " AND et.category_id = :category"; 
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['type']) && $filters['type'] !== 'any') {
            $query .= " AND et.type_name = :type"; // Тъй като в HTML пращаш името, а не ID-то
            $params['type'] = $filters['type'];
        }

        // Логика за цена (ако идва във формат напр. "0-50000" или "100000+")
        if (!empty($filters['price']) && $filters['price'] !== 'any') {
            if (strpos($filters['price'], '-') !== false) {
                list($min, $max) = explode('-', $filters['price']);
                $query .= " AND e.price >= :min_price AND e.price <= :max_price";
                $params['min_price'] = (float)$min;
                $params['max_price'] = (float)$max;
            } elseif (strpos($filters['price'], '+') !== false) {
                $min = str_replace('+', '', $filters['price']);
                $query .= " AND e.price >= :min_price";
                $params['min_price'] = (float)$min;
            }
        }

        // Подреждане от най-новите към най-старите (по желание)
        $query .= " ORDER BY e.creation_date DESC";

        $stmt = $db->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}
