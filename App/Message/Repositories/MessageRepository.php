<?php

namespace App\Message\Repositories;

use App\Message\DataMappers\MessageDataMapper;
use App\Message\Models\Message;
use Lewy\DataMapper\Repository;

class MessageRepository extends Repository
{
    protected $datamapper   = MessageDataMapper::class;
    protected $model        = Message::class;
}
