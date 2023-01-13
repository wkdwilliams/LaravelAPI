
# Laravel API
An API that heavily relies on object-oriented design. This API implements convenient data mapping of data obtained from repositories, to entities that represents the data, then lastly to a JSON resource.

Simple CRUD implementation eases the process of implementing your own API.

# Documentation
## Folder structure
The `Core` folder contains our middleware, jobs, providers etc. Typically in Laravel, this is the `app` directory. The `App` directory contains our resources. Do not mistake Laravel's `app` directory with the `App` directory here.
## Make a new resource
To conveniently create a new resource within the App directory, run this command:

    php artisan make:resource category
Then add the CRUD routes pointing to the newly created controller like so;

```php
Route::resource('/category', '\App\Category\Controllers\CategoryController');
```

This command also creates the migration, factory & provides the seeder you should include.

## Controller
### Create rules

Here we can define the validation rules for when we intend to create a resource.

```php
protected array $createRules = [
    'name'        => 'required|string',
    'description' => 'required|string|max:255'
];
```

### Update rules

Here we can define the validation rules for when we intend to update a resource.

```php
protected array $updateRules = [
    'name'        => 'required|string',
    'description' => 'required|string|max:255'
];
```

Properties not set in the rules will be ignored by the repository when updating & creating resources.

### Pagination
By default, pagination is disabled. When extending `Lewy\DataMapper\Controller`, you may override this inside your controller class with:

```php
protected int $paginate = 3;
```

This will return 3 results per page. Navigating to the endpoint `http://localhost/api/user?page=2` should access our records on page 2.

The content of the response will show in this kind of format, with the pagination information at the bottom;
```json
{
  "status": 200,
  "data": [
    {
      "id": "4",
      "name": "consequatur",
      "created_at": "2022-03-26 15:03:26",
      "updated_at": "2022-03-26 15:03:26"
    },
    {
      "id": "5",
      "name": "incidunt",
      "created_at": "2022-03-26 15:03:26",
      "updated_at": "2022-03-26 15:03:26"
    },
    {
      "id": "6",
      "name": "est",
      "created_at": "2022-03-26 15:03:26",
      "updated_at": "2022-03-26 15:03:26"
    }
  ],
  "total": 20000,
  "current_page": 2,
  "per_page": 3,
  "last_page": 6667
}
```

## Repository
The repository is what is used to obtain records from the model. The repository works similarly to the eloquent model.

### Obtaining data

```php
<?php

namespace App\User\Services;

use Lewy\DataMapper\EntityCollection;
use Lewy\DataMapper\Service;

class UserService extends Service
{
    public function getResources(): EntityCollection
    {
        return $this->repository
                    ->findAll()
                    ->orderBy('id', 'desc')
                    ->limit(5)
                    ->entityCollection();
    }
}
```
The above code will find all records from `users`, sort it by id in descending order, and limit the result by 5. If you expecting multiple results, you must return `entityCollection()`. If you're expecting only one result; then you can return `entity()`

```php
<?php

namespace App\User\Services;

use Lewy\DataMapper\EntityCollection;
use Lewy\DataMapper\Service;

class UserService extends Service
{
    public function getResourceById(): Entity
    {
        return $this->repository
                    ->findById(1)
                    ->entity()
    }
}
```

The above code will retrieve a record with the id of 1 and return an entity.

The repository does not inherit all the query building methods, and you may want to build a specific query without creating new methods in the repository. To get around this, you can access the query builder directly within a callback like so;
```php
<?php

namespace App\User\Services;

use Lewy\DataMapper\EntityCollection;
use Lewy\DataMapper\Service;

class UserService extends Service
{
    public function getResources(): EntityCollection
    {
        return $this->repository->findAll()->queryBuilder(function($model){
            return $model->groupBy('status');
        })->entityCollection();
    }
}
```

The above code will find all records, and group it by the `status` column.

### Caching
The repository will cache results if `APP_DEBUG` is set to false in the `.env` file

## Datamapper

The datamapper is what deals with the business logic. It converts data from a repository into data we can work with.

```php
protected function fromRepository(array $data): array
{
    return [
        'id'         => $data['id'],
        'name'       => $data['name'],
        'created_at' => $data['created_at'],
        'updated_at' => $data['updated_at'],
    ];
}
```

The above code demonstrates the mapping of data from the repository, and populates these values into an entity.

```php
protected function toRepository(array $data): array
{
    return [
        'name' => $data['name']
    ];
}
```

The above code demonstrates mapping data intended to go to the repository. Typically, for when we update and create records. Setting values for `id`, `created_at` and `updated_at` is not recommended since the database handles the creation of these fields, and the repository handles the updating of the `updated_at` field for us, and so the repository filters out these values.

```php
protected function fromEntity(Entity $data): array
{
    return [
        'id'         => $data->getId(),
        'name'       => $data->getName(),
        'updated_at' => $data->getUpdatedAt(),
        'created_at' => $data->getCreatedAt()
    ];
}
```

The above code demonstrates how we map data from an entity to an array.

## Entity

The entity is what represents of database records. When we grab data from the repository, the repository maps that data to the entity using the datamapper.

```php
class CategoryEntity extends Entity
{
    protected string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
```

The above code demonstrates how you should setup the entity when the database table has a `name` field. The Entity abstract class already has getters and setters for `id`, `created_at` and `updated_at`.