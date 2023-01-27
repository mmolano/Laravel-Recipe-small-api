<?php

namespace Database\Factories;

use App\Models\Authenticate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Authenticate>
 */
class AuthenticateFactory extends Factory
{
    protected $model = Authenticate::class;

    public function definition(): array
    {
        return [
            'token' => Str::random(20),
            'routes' => json_encode([
                'GET/recipes'
            ]),
            'name' => $this->faker->name()
        ];
    }
}
