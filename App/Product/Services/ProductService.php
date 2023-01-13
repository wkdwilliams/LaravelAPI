<?php

namespace App\Product\Services;

use App\Category\Repositories\CategoryRepository;
use App\Category\Services\CategoryService;
use Lewy\DataMapper\Entity;
use Lewy\DataMapper\Service;

class ProductService extends Service
{
    public function updateResource(array $data): Entity
    {
        return $this->repository->update($data);
    }

}