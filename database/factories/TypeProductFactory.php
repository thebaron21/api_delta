<?php

namespace Database\Factories;

use App\Models\TypeProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TypeProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'       =>  $this->faker->name(),
            'price'      =>  $this->faker->randomDigit(),
            'desc'       =>  $this->faker->text(500),
            'product_id' =>   $this->faker->numberBetween(1,100)
         ];
    }
}
