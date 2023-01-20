<?php

namespace App\Image\Models;

use Lewy\DataMapper\Model;

class Image extends Model
{
    protected $table = "images";

    public $fillable = [
        'message_id',
        'url'
    ];
}
