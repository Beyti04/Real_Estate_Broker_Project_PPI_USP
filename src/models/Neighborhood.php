<?php

namespace App\Models;

class Neighborhood
{
    private int $id;
    private int $locationId;
    private string $neighborhoodName;

    public function __construct(int $id, int $locationId, string $neighborhoodName)
    {
        $this->id = $id;
        $this->locationId=$locationId;
        $this->neighborhoodName=$neighborhoodName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }

    public function getNeighborhoodName(): string
    {
        return $this->neighborhoodName;
    }
}
