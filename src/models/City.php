<?php

namespace App\Models;

class City
{
    private int $id;
    private int $regionId;
    private string $cityNameBG;
    private string $cityNameEN;

    public function __construct(int $id, int $regionId, string $cityNameBG, string $cityNameEN)
    {
        $this->id = $id;
        $this->regionId = $regionId;
        $this->cityNameBG = $cityNameBG;
        $this->cityNameEN = $cityNameEN;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getRegionId(): int
    {
        return $this->regionId;
    }

    public function getCityNameBG(): string
    {
        return $this->cityNameBG;
    }

    public function getCityNameEN(): string
    {
        return $this->cityNameEN;
    }
}
