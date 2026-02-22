<?php

namespace App\Models;

use App\Models\ExposureType;

class Estate
{
    private int $id;
    private int $locationArea;
    private int $estateType;
    private ExposureType $exposureType;
    private int $rooms;
    private string $description;
    private int $listingType;
    private float $price;
    private int $ownerId;

    public function __construct(int $id, int $locationArea, int $estateType, ExposureType $exposureType, int $rooms, string $description, int $listingType, float $price, int $ownerId)
    {
        $this->id = $id;
        $this->locationArea = $locationArea;
        $this->estateType = $estateType;
        $this->exposureType = $exposureType;
        $this->rooms = $rooms;
        $this->description = $description;
        $this->listingType = $listingType;
        $this->price = $price;
        $this->ownerId = $ownerId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLocationArea(): int
    {
        return $this->locationArea;
    }

    public function getEstateType(): int
    {
        return $this->estateType;
    }

    public function getExposureType(): ExposureType
    {
        return $this->exposureType;
    }

    public function getRooms(): int
    {
        return $this->rooms;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getListingType(): int
    {
        return $this->listingType;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }
}
