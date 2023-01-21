<?php

use App\Product\Repositories\ProductRepository;
use App\Product\Services\ProductService;
use Tests\TestAuthRequests;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use TestAuthRequests;

    protected $repository           = ProductRepository::class;
    protected $service              = ProductService::class;
    protected string $endPointName  = "product";

    protected array $createParams = [
        'category_id' => "1",
        "name"        => "testProduct"
    ];

    protected array $updateParams = [
        "name"        => "updatedProduct"
    ];
}
