<?php

namespace Tests;

use App\User\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Lewy\DataMapper\Repository;
use Lewy\DataMapper\Service;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var string
     */
    protected string $endPointName;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var Service
     */
    protected $service;

    /**
     * @var array
     */
    protected array $createParams = [];

    /**
     * @var array
     */
    protected array $updateParams = [];

    protected function getAuthUser(): User
    {
        return User::find(1);
    }

    protected function getService(): Service
    {
        return new $this->service(new $this->repository);
    }

    protected function getRepository(): Repository
    {
        return new $this->repository;
    }
}
