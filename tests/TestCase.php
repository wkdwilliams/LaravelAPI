<?php

namespace Tests;

use App\User\Models\User;
use Core\Entity;
use Core\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var string
     */
    protected string $endPointName;

    protected $repository;

    /**
     * @var array
     */
    protected array $createParams = [];

    /**
     * @var array
     */
    protected array $updateParams = [];

    protected function getAuthUser()
    {
        return User::find(1);
    }
}
