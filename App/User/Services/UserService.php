<?php

namespace App\User\Services;

use Lewy\DataMapper\Entity;
use Lewy\DataMapper\Service;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    public function createResource(array $data): Entity
    {
        $data['password'] = Hash::make($data['password']);

        return parent::createResource($data);
    }
}