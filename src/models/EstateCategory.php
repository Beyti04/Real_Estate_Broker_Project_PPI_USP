<?php

namespace App\Models;

class EstateCategory
{
    private int $id;
    private string $categoryName;

    public function __construct(int $id, string $categoryName)
    {
        $this->id = $id;
        $this->categoryName = $categoryName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }
}