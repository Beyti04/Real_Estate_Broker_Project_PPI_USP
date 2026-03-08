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
                s.status_name
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
}
