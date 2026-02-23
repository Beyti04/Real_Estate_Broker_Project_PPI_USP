<?php

namespace App\Models;

class Region
{
    private int $id;
    private string $regionNameBG;
    private string $regionNameEN;

    public function __construct(int $id, string $regionNameBG, string $regionNameEN)
    {
        $this->id = $id;
        $this->regionNameBG = $regionNameBG;
        $this->regionNameEN = $regionNameEN;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRegionNameBG(): string
    {
        return $this->regionNameBG;
    }

    public function getRegionNameEN(): string
    {
        return $this->regionNameEN;
    }
}
