<?php

namespace App\Category\Repositories;

use App\Category\DataMappers\CategoryDataMapper;
use App\Category\Models\Category;
use Lewy\DataMapper\Repository;
    
class CategoryRepository extends Repository
{
    protected $datamapper   = CategoryDataMapper::class;
    protected $model        = Category::class;
}