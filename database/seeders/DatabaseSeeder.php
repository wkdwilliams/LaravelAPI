<?php

use App\Category\Models\Category;
use App\Image\Models\Image;
use App\Message\Models\Message;
use App\Product\Models\Product;
use \App\User\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(40)->create();
        Message::factory(3)->create();
        Image::factory(2)->create();
        Category::factory(20)->create();
        Product::factory(20)->create();
    }
}
