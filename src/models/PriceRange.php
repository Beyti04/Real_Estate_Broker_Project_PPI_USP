<?php

namespace App\Models;

class PriceRange
{
    private int $id;
    private int $listingType;
    private string $rangeName;
    private string $rangeValue;

    public function __construct(int $id, int $listingType, string $rangeName, string $rangeValue)
    {
        $this->id = $id;
        $this->listingType = $listingType;
        $this->rangeName = $rangeName;
        $this->rangeValue = $rangeValue;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getListingType(): int
    {
        return $this->listingType;
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
