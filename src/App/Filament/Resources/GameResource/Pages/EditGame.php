<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use Domain\Core\Actions\FinishGameAction;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGame extends EditRecord
{
    protected static string $resource = GameResource::class;

    protected $listeners = [
        'filament.ludomaniac.game.finish' => '$refresh',
    ];

    protected function getActions(): array
    {
        return [
            Actions\Action::make('End')
                ->icon('heroicon-o-clock')
                ->action(function (FinishGameAction $finishGameAction) {
                    $finishGameAction->execute($this->record);
                    $this->emit('filament.ludomaniac.game.finish');
                })
                ->label(__('core/game.actions.finish'))
                ->requiresConfirmation()
                ->modalSubheading(__('core/game.actions.finish_confirmation'))
            ,
            Actions\DeleteAction::make(),
        ];
    }
}
