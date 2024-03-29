<?php

namespace App\Product\Repositories;

use App\Product\DataMappers\ProductDataMapper;
use App\Product\Models\Product;
use Lewy\DataMapper\Repository;
    
class ProductRepository extends Repository
{
    protected $datamapper   = ProductDataMapper::class;
    protected $model        = Product::class;
}