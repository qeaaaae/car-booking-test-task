<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComfortCategory extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'level',
    ];

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class)
            ->withTimestamps();
    }

    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }
}
