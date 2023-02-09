<?php

namespace app\Models;

use app\Enums\GameEndTypeEnum;
use app\Enums\GameStateEnum;
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
        'game_end_type' => GameEndTypeEnum::class,
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

    public function gameMaster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'game_master_id');
    }

    public function currentState(): GameStateEnum
    {
        return match (true) {
            $this->finished_at?->isPast() => GameStateEnum::FINISHED,
            $this->started_at?->isPast() => GameStateEnum::STARTED,
            default => GameStateEnum::NOT_STARTED,
        };
    }

    /**
     * @return array<GameEndTypeEnum>
     */
    public function getPossibleGameEndTypes(): array
    {
        // TODO: Make this more typesafe
        $playersWithMaxScCount = $this->players()
            ->selectRaw('sc_count, count(*) as num_of_players')
            ->groupBy('sc_count')
            ->orderByDesc('sc_count')
            ->first()
            ->toArray()['num_of_players'];

        if ($playersWithMaxScCount === 1) {
            return GameEndTypeEnum::cases();
        }

        return [GameEndTypeEnum::DRAW];
    }
}
