<?php

use App\Category\Entities\CategoryEntity;
use App\Category\Repositories\CategoryRepository;
use App\Category\Services\CategoryService;
use Tests\TestCase;
use Tests\TestRequests;
use Illuminate\Support\Str;
use Lewy\DataMapper\Entity;

class CategoryTest extends TestCase
{

    use TestRequests;

    protected $repository           = CategoryRepository::class;
    protected $service              = CategoryService::class;
    protected string $endPointName  = "category";

    protected array $createParams = [
        'name' => "testCat"
    ];

    protected array $updateParams = [
        'name' => 'updatedCat'
    ];

    public function testCanCreateResourceWithEntity()
    {
        $newName = str::random(10);

        $category = new CategoryEntity();
        $category->setName($newName);

        $create = $this->getRepository()->create($category);
        
        $this->assertEquals($newName, $create->getName());

        $newCategory = $this->getService()->getResourceByName($newName);

        $this->assertEquals($newName, $newCategory->getName());
    }

    public function testCanUpdateResourceWithEntity()
    {
        $lastRecord = $this->getRepository()->orderBy('id', 'desc')->limit(1)->entity();

        $category = $this->getService()->getResourceById($lastRecord->getId());

        $newName = str::random(10);
        $category->setName($newName);

        $update = $this->getRepository()->update($category);

        $this->assertInstanceOf(Entity::class, $update);
        $this->assertEquals($newName, $update->getName());

        $newCategory = $this->getService()->getResourceById($lastRecord->getId());

        $this->assertEquals($newName, $newCategory->getName());
    }

    public function testCanDeleteResourceWithEntity()
    {
        $lastRecord = $this->getRepository()->orderBy('id', 'desc')->limit(1)->entity();
        $oldName    = $lastRecord->getName();

        $category = $this->getRepository()->delete($lastRecord);

        $this->assertInstanceOf(Entity::class, $category);

        $deleted = $this->getRepository()->orderBy('id', 'desc')->limit(1)->entity();

        $this->assertNotEquals($oldName, $deleted->getName());
    }

    public function testCanDeleteResourceWithRepositoryEloquent()
    {
        $newName = str::random(10);

        $newCategory = new CategoryEntity();
        $newCategory->setName($newName);

        $create = $this->getRepository()->create($newCategory);

        $lastRecord = $this->getRepository()->orderBy('id', 'desc')->limit(1);

        $category = $lastRecord->delete();

        $this->assertInstanceOf(Entity::class, $category);

        $deleted = $this->getRepository()->orderBy('id', 'desc')->limit(1)->entity();

        $this->assertNotEquals($newName, $deleted->getName());
    }

}
