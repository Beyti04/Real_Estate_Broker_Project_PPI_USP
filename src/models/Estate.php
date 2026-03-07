<?php

namespace App\Models;

use App\Models\ExposureType;

class Estate
{
    private int $id;
    private int $cityId;
    private int $neighborhoodId;
    private string $estateAddress;
    private int $estateTypeId;
    private string $exposureType;
    private int $rooms;
    private int $floor;
    private string $description;
    private int $listingTypeId;
    private float $price;
    private int $ownerId;
    private string $creationDate;
    private string $expirationDate;
    private int $statusId;

    public function __construct(
        int $id, int $cityId, int $neighborhoodId, string $estateAddress, int $estateTypeId, string $exposureType,
        int $rooms, int $floor, string $description, int $listingTypeId, float $price, int $ownerId, string $creationDate, string $expirationDate, int $statusId
    ) {
        $this->id = $id;
        $this->cityId = $cityId;
        $this->neighborhoodId = $neighborhoodId;
        $this->estateAddress = $estateAddress;
        $this->estateTypeId = $estateTypeId;
        $this->exposureType = $exposureType;
        $this->rooms = $rooms;
        $this->floor = $floor;
        $this->description = $description;
        $this->listingTypeId = $listingTypeId;
        $this->price = $price;
        $this->ownerId = $ownerId;
        $this->creationDate = $creationDate;
        $this->expirationDate = $expirationDate;
        $this->statusId = $statusId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCityId(): int
    {
        return $this->cityId;
    }

    public function getNeighborhoodId(): int
    {
        return $this->neighborhoodId;
    }

    public function getEstateAddress(): string
    {
        return $this->estateAddress;
    }

    public function getEstateTypeId(): int
    {
        return $this->estateTypeId;
    }

    public function getExposureType(): string
    {
        return $this->exposureType;
    }

    public function getRooms(): int
    {
        return $this->rooms;
    }

    public function getFloor(): int
    {
        return $this->floor;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getListingTypeId(): int
    {
        return $this->listingTypeId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function getExpirationDate(): string
    {
        return $this->expirationDate;
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }
}
