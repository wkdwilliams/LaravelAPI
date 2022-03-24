<?php

namespace Tests;

use App\User\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getAuthUser()
    {
        return User::find(1);
    }
}
