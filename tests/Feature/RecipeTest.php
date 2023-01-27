<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function getAllRecipe(): void
    {
        $response = $this->getWithAuth('/api/v1.0/recipe')
            ->assertStatus(200);


        $response->assertStatus(200);
    }
}
