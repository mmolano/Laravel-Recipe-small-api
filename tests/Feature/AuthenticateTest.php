<?php

namespace Tests\Feature;

use App\Models\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use RefreshDatabase;

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

    /**
     * @test
     */
    public function connectWithBadToken(): void
    {
        $response = $this->get('/api/v1.0/authCheck', [
            'Authorization' => 'Bearer testToken'
        ])
            ->assertStatus(401);

        $this->assertEquals(2, $response->json()['code']);
        $this->assertEquals(401, $response->json()['handlerCode']);
        $this->assertEquals('Bad Token', $response->json()['message']);
        $this->assertEquals(true, $response->json()['is_general']);
    }

    /**
     * @test
     */
    public function connectWithGoodToken(): void
    {
        $auth = Authenticate::create([
            'name' => 'standard',
            'token' => Str::random(20),
            'routes' => json_encode([
                '*'
            ])
        ]);

        $response = $this->get('/api/v1.0/authCheck', [
            'Authorization' => 'Bearer ' . $auth->token
        ])
            ->assertStatus(200)
            ->assertExactJson([
                'status' => 200,
                'message' => 'Response successful'
            ]);
    }

    /**
     * @test
     */
    public function connectWithGoodTokenWrongRoute(): void
    {
        $auth = Authenticate::create([
            'name' => 'standard',
            'token' => Str::random(20),
            'routes' => json_encode([
                'GET/recipe'
            ])
        ]);

        $response = $this->get('/api/v1.0/authCheck', [
            'Authorization' => 'Bearer ' . $auth->token
        ])
            ->assertStatus(401);


        $this->assertEquals(3, $response->json()['code']);
        $this->assertEquals(401, $response->json()['handlerCode']);
        $this->assertEquals('Unauthorized', $response->json()['message']);
        $this->assertEquals(true, $response->json()['is_general']);
    }

    /**
     * @test
     */
    public function connectWithGoodTokenGoodRoute(): void
    {
        $auth = Authenticate::create([
            'name' => 'standard',
            'token' => Str::random(20),
            'routes' => json_encode([
                'GET/authCheck'
            ])
        ]);

        $response = $this->get('/api/v1.0/authCheck', [
            'Authorization' => 'Bearer ' . $auth->token
        ])
            ->assertStatus(200)
            ->assertExactJson([
                'status' => 200,
                'message' => 'Response successful'
            ]);
    }
}
