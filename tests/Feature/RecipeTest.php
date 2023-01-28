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
        $recipe = $this->createRecipe();
        $recipe2 = $this->createRecipe();

        $response = $this->getWithAuth('/api/v1.0/recipe')
            ->assertStatus(200)
            ->assertJsonCount(2);

        $this->checkRecipe($recipe, $response->json()[0]);
        $this->checkRecipe($recipe2, $response->json()[1]);
    }

    /**
     * @test
     */
    public function getOneRecipe(): void
    {
        $recipe = $this->createRecipe();

        $response = $this->getWithAuth('/api/v1.0/recipe/' . $recipe['id'])
            ->assertStatus(200);

        $this->checkRecipe($recipe, $response->json());
    }

    /**
     * @test
     */
    public function updateRecipe(): void
    {
        $recipe = $this->createRecipe();

        $newValues = [
            'name' => 'Updated name',
            'stars' => 3,
            'difficultyType' => 'advanced'
        ];

        $response = $this->putWithAuth('/api/v1.0/recipe/' . $recipe['id'], $newValues)
            ->assertStatus(200);

        $this->assertEquals($newValues['name'], $response->json()['name']);
        $this->assertEquals($newValues['difficultyType'], $response->json()['difficultyType']);
        $this->assertEquals($newValues['stars'], $response->json()['rating'][0]['stars']);
    }
}
