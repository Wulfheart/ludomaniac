<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Actions\InitializeGameAction;
use App\Filament\Resources\GameResource;
use App\Models\Game;
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
