<?php

namespace Domain\Core\Models;

use Domain\Core\Enums\GameStateEnum;
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

    public function currentState(): GameStateEnum
    {
        return match (true) {
            $this->finished_at?->isPast() => GameStateEnum::FINISHED,
            $this->started_at?->isPast() => GameStateEnum::STARTED,
            default => GameStateEnum::NOT_STARTED,
        };
    }
}
