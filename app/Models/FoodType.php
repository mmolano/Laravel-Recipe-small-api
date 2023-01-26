<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodType extends Model
{
    use HasFactory;

    public $incrementing = true;
    public $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $table = 'FoodType';
    protected $fillable = [
        'type',
        'recipeId'
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipeId');
    }
}
