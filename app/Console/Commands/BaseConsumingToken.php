<?php

namespace App\Console\Commands;

use App\Models\Authenticate;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BaseConsumingToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'standard:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a based token to consume API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (!Authenticate::where('name', 'standard')->first()) {
            Authenticate::create([
                'name' => 'standard',
                'token' => Str::random(20),
                'routes' => json_encode([
                    '*'
                ])
            ]);
        }
        return 0;
    }
}
