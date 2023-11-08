<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tire;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TireFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tire::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = Type::first();
        $category = Category::first();

        return [
            'category_id' => $category->id,
            'millimeters' => $this->faker->randomFloat(),
            'millimeters_2' => $this->faker->randomFloat(),
            'millimeters_new_by_manufacturer' => $this->faker->randomFloat(),
            'width' => $this->faker->randomNumber(),
            'profile' => $this->faker->randomNumber(),
            'diameter' => $this->faker->randomNumber(),
            'brand' => Str::random(10),
            'model' => Str::random(10),
            'type_id' => $type->id,
            'load_index' => Str::random(1),
            'speed_index' => Str::random(1),
            'is_commercial' => 0,
            'dot' => '2021',
            'amount' => $this->faker->numberBetween(1, 6),
            'rack_identifier' => Str::random(1),
            'rack_position' => $this->faker->numberBetween(1, 99),
            'price_new' => $this->faker->randomFloat(),
            'price_new_with_iva' => $this->faker->randomFloat(),
            'price' => $this->faker->randomFloat(),
            'price_not_discounted' => $this->faker->randomFloat(),
            'price_ebay' => $this->faker->randomFloat(),
            'status' => 1,
        ];
    }
}
