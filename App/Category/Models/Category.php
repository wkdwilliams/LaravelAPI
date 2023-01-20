<?php

namespace App\Category\Models;
    
use Lewy\DataMapper\Model;
    
class Category extends Model
{
    protected $table = "categories";
    
    protected $appends = [
            
    ];

    public $fillable = [
        'name'
    ];
}
