<?php

namespace App\Models;

use App\Models\ExposureType;
use App\Models\ListingType;

class Estate{
    private int $id;
    private int $location_area;
    private int $estate_type;
    private ExposureType $exposure_type;
    private int $rooms;
    private string $description;
    private ListingType $listing_type;
    private float $price;
    private int $owner_id;

    public function __construct(int $id, int $location_area, int $estate_type, ExposureType $exposure_type, int $rooms, string $description, ListingType $listing_type, float $price, int $owner_id)
    {
        $this->id = $id;
        $this->location_area = $location_area;
        $this->estate_type = $estate_type;
        $this->exposure_type = $exposure_type;
        $this->rooms = $rooms;
        $this->description = $description;
        $this->listing_type = $listing_type;
        $this->price = $price;
        $this->owner_id = $owner_id;
    }
    
    public function getId(): int
    {
        return $this->id;
    }

    public function getLocationArea(): int
    {
        return $this->location_area;
    }

    public function getEstateType(): int
    {
        return $this->estate_type;
    }

    public function getExposureType(): ExposureType
    {
        return $this->exposure_type;
    }

    public function getRooms(): int
    {
        return $this->rooms;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getListingType(): ListingType
    {
        return $this->listing_type;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getOwnerId(): int
    {
        return $this->owner_id;
    }
}