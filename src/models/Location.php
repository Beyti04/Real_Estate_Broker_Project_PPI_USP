<?php

namespace App\Models;

class Location
{
    private int $id;
    private int $regionId;
    private string $locationName;

    public function __construct(int $id, int $regionId, string $locationName)
    {
        $this->id = $id;
        $this->regionId = $regionId;
        $this->locationName = $locationName;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getRegionId(): int
    {
        return $this->regionId;
    }

    public function getLocationName(): string
    {
        return $this->locationName;
    }
}
