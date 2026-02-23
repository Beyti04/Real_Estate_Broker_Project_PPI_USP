<?php

namespace App\Controllers;

use App\Models\City;
use Config\Database;
use PDO, PDOException;

class CityController
{
    public static function getAllCities()
    {
        $pdo = Database::getInstance();
        $cities = [];

        try {
            $stmt = $pdo->query("SELECT id, region_id,city_name_bg,city_name_en FROM cities");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cities[] = new City($row['id'], $row['region_id'], $row['city_name_bg'], $row['city_name_en']);
            }
        } catch (PDOException $e) {
            die('Error fetching cities: ' . $e->getMessage());
        }

        return $cities;
    }

    public static function getCityById(int $id): ?City
    {
        $pdo = Database::getInstance();
        try {
            $stmt = $pdo->prepare("SELECT id, region_id,city_name_bg,city_name_en FROM cities WHERE id=:id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new City($row['id'], $row['region_id'], $row['city_name_bg'], $row['city_name_en']);
            } else {
                throw new PDOException("City not found");
            }
        } catch (PDOException $e) {
            die('Error fetching cities: ' . $e->getMessage());
        }
    }
}
