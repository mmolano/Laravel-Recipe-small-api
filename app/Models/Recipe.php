<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static get(mixed $value)
 * @method static where(mixed $value, mixed $value)
 * @method static create(array $array)
 */
class Recipe extends Model
{
    use HasFactory;

    public $incrementing = true;
    protected $keyType = 'integer';
    protected $table = 'Recipe';
    protected $fillable = [
        'name',
        'difficultyType',
        'timeToPrepare',
        'ingredients',
        'videoLink',
        'foodCountry'
    ];

    public function type(): HasMany
    {
        return $this->hasMany(FoodType::class, 'recipeId');
    }

    public function rating(): HasMany
    {
        return $this->hasMany(Rating::class, 'recipeId');
    }

}
