<?php

namespace Database\Factories;

use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rating>
 */
class RatingFactory extends Factory
{
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stars' => $this->faker->numberBetween(1, 5),
            'recipeId' => self::factoryForModel(Recipe::class),
        ];
    }
}
