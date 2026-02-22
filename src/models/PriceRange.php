<?php

namespace App\Models;

class PriceRange
{
    private int $id;
    private string $rangeName;
    private string $rangeValue;

    public function __construct(int $id, string $rangeName, string $rangeValue)
    {
        $this->id = $id;
        $this->rangeName = $rangeName;
        $this->rangeValue = $rangeValue;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRangeName(): string
    {
        return $this->rangeName;
    }

    public function getRangeValue(): string
    {
        return $this->rangeValue;
    }
}
