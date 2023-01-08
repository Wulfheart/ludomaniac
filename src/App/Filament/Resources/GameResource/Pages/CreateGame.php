<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use Domain\Core\Actions\InitializeGameAction;
use Domain\Core\Models\Game;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateGame extends CreateRecord
{
    protected static string $resource = GameResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        /** @var Game $game */
        $game = static::getModel()::create($data);

        /** @var InitializeGameAction $action */
        $action = app(InitializeGameAction::class);
        $action->execute($game);
        return $game;
    }
}
