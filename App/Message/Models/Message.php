<?php

namespace App\Message\Models;

use App\Image\Models\Image;
use Lewy\DataMapper\Model;

class Message extends Model
{
    protected $table = "messages";

    protected $appends = [
        'images'
    ];

    public $fillable = [
        'user_id',
        'message'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function getImagesAttribute()
    {
        return $this->images()->get();
    }
}
