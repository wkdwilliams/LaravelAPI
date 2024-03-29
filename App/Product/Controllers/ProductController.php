<?php

namespace App\Product\Controllers;

use App\Product\DataMappers\ProductDataMapper;
use App\Product\Repositories\ProductRepository;
use App\Product\Resources\ProductCollection;
use App\Product\Resources\ProductResource;
use App\Product\Services\ProductService;
use Lewy\DataMapper\Traits\ResourceMustBelongToAuthenticatedUser;
use Lewy\DataMapper\Controller;

class ProductController extends Controller
{
    use ResourceMustBelongToAuthenticatedUser;

    protected array $classes = [
        'datamapper' => ProductDataMapper::class,
        'repository' => ProductRepository::class,
        'resource'   => ProductResource::class,
        'collection' => ProductCollection::class,
        'service'    => ProductService::class
    ];

    protected array $createRules = [
        'category_id'   => 'required',
        'name'          => 'required|string|max:15'
    ];

    protected array $updateRules = [
        'category_id'   => 'integer',
        'name'          => 'string|max:15'
    ];

}
