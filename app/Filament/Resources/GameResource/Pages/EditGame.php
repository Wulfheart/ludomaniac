<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Actions\FinishGameAction;
use App\Enums\GameEndTypeEnum;
use App\Filament\Resources\GameResource;
use App\Models\Game;
use Filament\Forms\Components\Select;
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
                    $finishGameAction->execute($this->record, GameEndTypeEnum::DRAW);
                    $this->emit('filament.ludomaniac.game.finish');
                })
                ->form([
                    Select::make('end_type')
                        ->label(__('core/game.attributes.game_end_type'))
                        ->options(fn (Game $record) => // TODO: Test
                        collect($record->getPossibleGameEndTypes())
                            ->pluck('value', 'name')
                            ->flip()
                            ->map(fn (string $value) => __('core/game.states.game_end_type.'.$value))
                            ->toArray()
                        ),
                ])
                ->label(__('core/game.actions.finish'))
                ->requiresConfirmation()
                ->modalSubheading(__('core/game.actions.finish_confirmation')),
            Actions\DeleteAction::make(),
        ];
    }
}
