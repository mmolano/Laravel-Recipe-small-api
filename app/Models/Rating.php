<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    public $incrementing = true;
    public $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $table = 'Rating';
    protected $fillable = [
        'stars',
        'recipeId'
    ];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipeId');
    }
}
