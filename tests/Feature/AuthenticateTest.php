<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    /**
     * @test
     */
    public function accessApi(): void
    {
        $response = $this->get('/api/v1.0/apiCheck')
            ->assertSuccessful()
            ->assertExactJson([
                'status' => 200,
                'message' => 'This service is up and running!'
            ]);
    }

    /**
     * @test
     */
    public function connectWithoutToken(): void
    {
        $response = $this->get('/api/v1.0/authCheck')
            ->assertStatus(400);

        $this->assertEquals(1, $response->json()['code']);
        $this->assertEquals(400, $response->json()['handlerCode']);
        $this->assertEquals('Empty Token', $response->json()['message']);
        $this->assertEquals(true, $response->json()['is_general']);
    }
}
