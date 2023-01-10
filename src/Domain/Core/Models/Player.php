<?php

namespace Domain\Core\Models;

use Domain\Core\Builders\PlayerBuilder;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function newEloquentBuilder($query): PlayerBuilder
    {
        return new PlayerBuilder($query);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function power(): BelongsTo
    {
        return $this->belongsTo(Power::class);
    }

    public function canBeBanned(): bool
    {
        return $this->user_id !== null;
    }

    public function canAcceptPlayer(): bool
    {
        return $this->user_id === null;
    }
}
