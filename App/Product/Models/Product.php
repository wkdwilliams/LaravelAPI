<?php

namespace App\Product\Models;

use App\Category\Models\Category;
use Lewy\DataMapper\Model;

class Product extends Model
{
    protected $table = "products";
    
    protected $appends = [
        'category'
    ];

    public $fillable = [
        'user_id',
        'category_id',
        'name'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getCategoryAttribute()
    {
        return $this->category()->get();
    }

}
