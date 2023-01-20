<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $routes
 * @method static where(string $string, string|null $value)
 * @method static create(array $array)
 */
class Authenticate extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $keyType = 'integer';
    protected $table = 'Authenticate';
    protected $fillable = [
        'name',
        'token',
        'routes'
    ];
}
