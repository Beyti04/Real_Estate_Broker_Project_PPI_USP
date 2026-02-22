<?php

namespace App\Models;

class EstateType
{
    private int $id;
    private string $typeName;

    public function __construct(int $id, string $typeName)
    {
        $this->id = $id;
        $this->typeName = $typeName;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTypeName(): string
    {
        return $this->typeName;
    }
}