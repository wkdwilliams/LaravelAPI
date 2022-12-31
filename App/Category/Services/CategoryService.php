<?php

namespace App\Category\Services;

use Lewy\DataMapper\Entity;
use Lewy\DataMapper\Service;

class CategoryService extends Service
{

    public function getResourceByName(string $name): Entity
    {
        return $this->repository->findByColumn('name', $name)->entity();
    }
        
}