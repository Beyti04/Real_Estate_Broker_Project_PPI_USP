<?php

namespace App\Models;

class UserType
{
    private int $id;
    private string $typeName;

    public function __construct(int $id, string $typeName)
    {
        $this->id = $id;
        $this->typeName = $typeName;
    }
}
