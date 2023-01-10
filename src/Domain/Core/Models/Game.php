<?php

namespace Domain\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function signedUpUsers(): HasMany
    {
        return $this->hasMany(GameSignedUpUsers::class);
    }
}
