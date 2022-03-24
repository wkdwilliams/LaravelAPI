<?php

namespace Database\Factories;

use App\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'       => $this->faker->numberBetween(1, 5),
            'category_id'   => $this->faker->numberBetween(1, 20),
            'name'          => $this->faker->word(),
        ];
    }
}