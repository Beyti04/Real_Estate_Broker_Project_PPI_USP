<?php

namespace App\Models;

class EstateType
{
    private int $id;
    private string $typeName;
    private int $categoryId;

    public function __construct(int $id, string $typeName, int $categoryId)
    {
        $this->id = $id;
        $this->typeName = $typeName;
        $this->categoryId = $categoryId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
