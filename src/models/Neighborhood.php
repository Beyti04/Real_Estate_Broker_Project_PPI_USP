<?php

namespace App\Models;

class Neighborhood
{
    private int $id;
    private int $locationId;
    private string $neighborhoodNameBG;
    private string $neighborhoodNameEN;

    public function __construct(int $id, int $locationId, string $neighborhoodNameBG, string $neighborhoodNameEN)
    {
        $this->id = $id;
        $this->locationId = $locationId;
        $this->neighborhoodNameBG = $neighborhoodNameBG;
        $this->neighborhoodNameEN = $neighborhoodNameEN;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }

    public function getNeighborhoodNameBG(): string
    {
        return $this->neighborhoodNameBG;
    }

    public function getNeighborhoodNameEN(): string
    {
        return $this->neighborhoodNameEN;
    }
}
