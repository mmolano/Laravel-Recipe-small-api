<?php

namespace Tests;

use App\Models\Authenticate;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public Generator $faker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = Factory::create('fr_FR');
    }

    public function createAuth(): Authenticate
    {
        return Authenticate::create([
            'name' => 'standard',
            'token' => Str::random(20),
            'routes' => json_encode([
                '*'
            ])
        ]);
    }
    public function getWithAuth(string $url): TestResponse
    {
        $auth = $this->createAuth();

        return $this->get($url, [
            'Authorization' => 'Bearer ' . $auth->token
        ]);
    }

    public function postWithAuth(string $url, array $params = []): TestResponse
    {
        $auth = $this->createAuth();

        return $this->post($url, $params, [
            'Authorization' => 'Bearer ' . $auth->token
        ]);
    }

    public function putWithAuth(string $url, array $params = []): TestResponse
    {
        $auth = $this->createAuth();

        return $this->put($url, $params, [
            'Authorization' => 'Bearer ' . $auth->token
        ]);
    }

    public function deleteWithAuth(string $url, array $params = []): TestResponse
    {
        $auth = $this->createAuth();

        return $this->delete($url, $params, [
            'Authorization' => 'Bearer ' . $auth->token
        ]);
    }
}
