<?php

namespace App\Category\Controllers;

use App\Category\DataMappers\CategoryDataMapper;
use App\Category\Repositories\CategoryRepository;
use App\Category\Resources\CategoryCollection;
use App\Category\Resources\CategoryResource;
use App\Category\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Lewy\DataMapper\Controller;

class CategoryController extends Controller
{

    protected int $paginate = 5;

    protected array $classes = [
        'datamapper' => CategoryDataMapper::class,
        'repository' => CategoryRepository::class,
        'resource'   => CategoryResource::class,
        'collection' => CategoryCollection::class,
        'service'    => CategoryService::class
    ];

    protected array $createRules = [
        'name' => 'required'
    ];

    protected array $updateRules = [
        'name' => 'required'
    ];

    public function getResourceByName(string $name): JsonResponse
    {
        $repos = $this->service->getResourceByName($name);

        return $this->response(
            new $this->classes['resource']($repos)
        );
    }

}
