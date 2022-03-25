<?php

use App\Category\Repositories\CategoryRepository;
use Core\Repository;
use Tests\TestCase;
use Tests\TestRequests;

class CategoryTest extends TestCase
{

    use TestRequests;

    protected $repository           = CategoryRepository::class;
    protected string $endPointName  = "category";

    protected array $createParams = [
        'name' => "testCat"
    ];

    protected array $updateParams = [
        'name' => 'updatedCat'
    ];

}
