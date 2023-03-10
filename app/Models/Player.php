<?php

namespace App\Models;

use App\Builders\PlayerBuilder;
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

    //public function NMRs(): HasMany
    //{
    //
    //    // TODO: Open issue on laravel/framework for this
    //    // https://github.com/laravel/framework/issues/25362
    //    //return $this->hasMany(NMR::class, 'user_id', 'user_id')->where('game_id', $this->game_id);
    //}

    public function canBeBanned(): bool
    {
        return $this->user_id !== null;
    }

    public function canAcceptPlayer(): bool
    {
        return $this->user_id === null;
    }
}
