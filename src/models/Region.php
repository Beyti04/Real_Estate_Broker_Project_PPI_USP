<?php

namespace App\Models;

class Region{
    private int $id;
    private string $regionName;

    public function __construct(int $id, string $regionName)
    {
        $this->id = $id;
        $this->regionName = $regionName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRegionName(): string
    {
        return $this->regionName;
    }
}