<?php

namespace App\Models;

class Neighborhood
{
    private int $id;
    private int $cityId;
    private string $neighborhoodNameBG;
    private string $neighborhoodNameEN;

    public function __construct(int $id, int $cityId, string $neighborhoodNameBG, string $neighborhoodNameEN)
    {
        $this->id = $id;
        $this->cityId = $cityId;
        $this->neighborhoodNameBG = $neighborhoodNameBG;
        $this->neighborhoodNameEN = $neighborhoodNameEN;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCityId(): int
    {
        return $this->cityId;
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
