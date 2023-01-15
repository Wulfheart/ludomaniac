<?php

namespace Domain\Users\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Domain\Core\Models\GameSignedUpUsers;
use Domain\Core\Models\Player;
use Domain\Forum\Events\ForumUserCreatedEvent;
use Domain\Users\Builders\UserBuilder;
use Domain\Users\Enums\RankEnum;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rank',
        'is_admin',
        'is_game_master',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'rank' => RankEnum::class,
    ];

    protected static function booted()
    {
        static::created(function (User $user) {
            ForumUserCreatedEvent::dispatch($user->id);
        });
    }

    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    public function canAccessFilament(): bool
    {
        return $this->is_admin || $this->is_game_master;
    }

    public function playsIn(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function signedUpGames(): HasMany
    {
        return $this->hasMany(GameSignedUpUsers::class);
    }

    // This could also be done via policy
    public function displayName(): Attribute
    {
        return new Attribute(get: fn () => auth()->user() ? $this->full_name ?? $this->name : $this->name);
    }
}
