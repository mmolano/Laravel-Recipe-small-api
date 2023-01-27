<?php

namespace Database\Factories;

use App\Models\FoodType;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FoodType>
 */
class FoodTypeFactory extends Factory
{
    protected $model = FoodType::Class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => collect(['breakfast', 'main', 'dessert', 'salad', 'soup', 'side'])->random(),
            'recipeId' => self::factoryForModel(Recipe::class),
        ];
    }
}
