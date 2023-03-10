<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static write(int $int, bool $generalError = false)
 * @method static setCustom(array $pathArray, array $errors)
 * @method static setValidationError(int $int, $json)
 */
class ErrorHandler extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'errorHandler';
    }
}
