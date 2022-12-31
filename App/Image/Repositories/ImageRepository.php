<?php

namespace App\Image\Repositories;

use App\Image\DataMappers\ImageDataMapper;
use App\Image\Models\Image;
use Lewy\DataMapper\Repository;

class ImageRepository extends Repository
{
    protected $datamapper   = ImageDataMapper::class;
    protected $model        = Image::class;
}
