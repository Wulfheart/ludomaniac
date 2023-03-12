<?php

namespace Tests\Unit\Models;

use App\Enums\GameStateEnum;
use App\Models\Game;
use App\Models\GameSignedUpUsers;
use App\Models\User;
use App\Models\Variant;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class GameTest extends TestCase
{
    public function test_belongs_to_variant(): void
    {
        $variant = Variant::factory()->create();
        $game = Game::factory()->create(['variant_id' => $variant->id]);

        $this->assertInstanceOf(Variant::class, $game->variant);
        $this->assertEquals($variant->id, $game->variant->id);
    }

    public function test_has_many_players(): void
    {
        $game = Game::factory()->create();
        $this->assertInstanceOf(Collection::class, $game->players);
    }

    public function test_has_many_signed_up_users(): void
    {
        $game = Game::factory()->create();

        GameSignedUpUsers::factory()->count(3);
        GameSignedUpUsers::factory()->forGame($game)->count(4)->create();
        $this->assertInstanceOf(Collection::class, $game->signedUpUsers);
        $this->assertCount(4, $game->signedUpUsers);
    }

    public function test_belongs_to_game_master(): void
    {
        $randomUsers = User::factory()->count(3)->create();

        $gameMaster = $randomUsers->first();
        $game = Game::factory()->forGameMaster($gameMaster)->create();
        $this->assertInstanceOf(User::class, $game->gameMaster);
        $this->assertEquals($gameMaster->id, $game->gameMaster->id);
    }

    public function test_belongs_to_game_master_can_be_null(): void
    {
        $game = Game::factory()->create();
        $this->assertNull($game->gameMaster);
    }

    /**
     * @dataProvider currentStateProvider
     */
    public function test_current_state(
        ?DateTimeImmutable $finishedAt,
        ?DateTimeImmutable $startedAt,
        GameStateEnum $expectedState
    ): void {
        $game = Game::factory()->make([
            'finished_at' => $finishedAt,
            'started_at' => $startedAt,
        ]);
        $this->assertEquals($expectedState, $game->currentState());
    }

    public function currentStateProvider(): array
    {
        return [
            'default state if nothing is set' => [
                'finishedAt' => null,
                'startedAt' => null,
                'expectedState' => GameStateEnum::NOT_STARTED,
            ],
            'not started if started is in future' => [
                'finishedAt' => null,
                'startedAt' => now()->addDay()->toDateTimeImmutable(),
                'expectedState' => GameStateEnum::NOT_STARTED,
            ],
            'started if started_at is in past' => [
                'finishedAt' => null,
                'startedAt' => now()->subDay()->toDateTimeImmutable(),
                'expectedState' => GameStateEnum::STARTED,
            ],
            'not finished if finished_at is in future' => [
                'finishedAt' => now()->addDay()->toDateTimeImmutable(),
                'startedAt' => now()->subDays(2)->toDateTimeImmutable(),
                'expectedState' => GameStateEnum::STARTED,
            ],
            'finished if finished_at is in past' => [
                'finishedAt' => now()->subDay()->toDateTimeImmutable(),
                'startedAt' => now()->subDays(2)->toDateTimeImmutable(),
                'expectedState' => GameStateEnum::FINISHED,
            ],
        ];
    }
}
