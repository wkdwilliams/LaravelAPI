<?php

namespace App\Category\Entities;
    
use Lewy\DataMapper\Entity;
    
class CategoryEntity extends Entity
{
    protected string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
