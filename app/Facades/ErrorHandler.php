<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static write(int $int, true $true)
 */
class ErrorHandler extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'errorHandler';
    }
}
