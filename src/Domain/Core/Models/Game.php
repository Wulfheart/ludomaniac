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

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
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

    public function hasStarted(): bool
    {
        return $this->started_at !== null && $this->started_at->isPast();
    }

    public function hasFinished(): bool
    {
        return $this->finished_at !== null && $this->finished_at->isPast();
    }
}
