<?php

use App\Category\Entities\CategoryEntity;
use App\Category\Repositories\CategoryRepository;
use App\Category\Services\CategoryService;
use Dotenv\Parser\Value;
use Tests\TestCase;
use Tests\TestRequests;
use Illuminate\Support\Str;
use Lewy\DataMapper\Entity;
use Lewy\DataMapper\EntityCollection;

use function PHPUnit\Framework\assertEquals;

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

        $newName = str::random(10);
        $lastRecord->setName($newName);

        $update = $this->getRepository()->update($lastRecord);

        $this->assertInstanceOf(Entity::class, $update);
        $this->assertEquals($newName, $update->getName());

        $newCategory = $this->getService()->getResourceById($lastRecord->getId());

        $this->assertEquals($newName, $newCategory->getName());
    }

    public function testCanDeleteResourceWithEntity()
    {
        $lastRecord = $this->getRepository()->lastRecord()->entity();
        $oldName    = $lastRecord->getName();

        $deleted = $this->getRepository()->delete($lastRecord);

        $this->assertInstanceOf(Entity::class, $deleted);

        $newRecord = $this->getRepository()->lastRecord()->entity();

        $this->assertNotEquals($oldName, $newRecord->getName());
    }

    public function testCanCreateResourceWithMultipleData()
    {
        $data = [];

        for ($i = 0; $i < 10; $i++)
            $data[] = [
                'name' => Str::random(5)
            ];

        $created = $this->getRepository()->createMultiple($data);

        $this->assertInstanceOf(EntityCollection::class, $created);
        $this->assertEquals(10, $created->count());

        foreach ($data as $i => $value) {
            assertEquals($value['name'], $created->getEntities()[$i]->getName());
        }
    }

    public function testCanCreateResourceWithEntityCollection()
    {
        $entities = new EntityCollection();
        $names    = [];

        for ($i = 0; $i < 10; $i++)
        {
            $entity     = new CategoryEntity();
            $name       = Str::random();
            $names[]    = $name;
            $entity->setName($name);
            $entities->push($entity);
        }

        $created = $this->getRepository()->createMultiple($entities);

        $this->assertInstanceOf(EntityCollection::class, $created);
        $this->assertEquals(10, $created->count());

        foreach ($entities->getEntities() as $i => $value) {
            assertEquals($value->getName(), $created->getEntities()[$i]->getName());
        }
    }

    public function testCanUpdateResourceWithMultipleData()
    {
        $entities = [];
        $names    = [];

        $records = $this->getRepository()->orderBy('id', 'desc')->limit(10)->entityCollection();

        foreach($records->getEntities() as $e)
        {
            $name       = Str::random();
            $names[]    = $name;
            $entities[] = [
                'id'   => $e->getId(),
                'name' => $name
            ];
        }

        $updated = $this->getRepository()->updateMultiple($entities);

        $this->assertInstanceOf(EntityCollection::class, $updated);
        $this->assertEquals(10, $updated->count());

        foreach ($entities as $i => $value) {
            assertEquals($value['name'], $updated->getEntities()[$i]->getName());
        }
    }

    public function testCanUpdateResourceWithEntityCollection()
    {
        $entities = new EntityCollection();
        $names    = [];

        $records = $this->getRepository()->orderBy('id', 'desc')->limit(10)->entityCollection();

        foreach($records->getEntities() as $e)
        {
            $name       = Str::random();
            $names[]    = $name;
            $e->setName($name);
            $entities->push($e);
        }

        $updated = $this->getRepository()->updateMultiple($entities);

        $this->assertInstanceOf(EntityCollection::class, $updated);
        $this->assertEquals(10, $updated->count());

        foreach ($entities->getEntities() as $i => $value) {
            assertEquals($value->getName(), $updated->getEntities()[$i]->getName());
        }
    }

    public function testCanDeleteResourceWithEntityCollection()
    {
        $lastRecord = $this->getRepository()->orderBy('id', 'desc')->limit(20)->entityCollection();

        $category = $this->getRepository()->deleteMultiple($lastRecord);

        $this->assertInstanceOf(EntityCollection::class, $category);
    }

    public function testCanDeleteResourceWithMultipleData()
    {
        // We have to create more records
        $entities = new EntityCollection();
        $names    = [];

        for ($i = 0; $i < 10; $i++)
        {
            $entity     = new CategoryEntity();
            $name       = Str::random();
            $names[]    = $name;
            $entity->setName($name);
            $entities->push($entity);
        }

        $created = $this->getRepository()->createMultiple($entities);

        $ids = [];

        $lastRecord = $this->getRepository()->orderBy('id', 'desc')->limit(10)->entityCollection();

        foreach ($lastRecord->getEntities() as $value) {
            $ids[] = [
                'id' => $value->getId()
            ];
        }

        $category = $this->getRepository()->deleteMultiple($ids);

        $this->assertInstanceOf(EntityCollection::class, $category);
    }

}
