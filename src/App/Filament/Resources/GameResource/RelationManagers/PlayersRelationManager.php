<?php

namespace App\Filament\Resources\GameResource\RelationManagers;

use Domain\Core\Actions\AddNMRForPlayerAction;
use Domain\Core\Actions\AssignUserToGameAction;
use Domain\Core\Actions\BanUserFromGameAction;
use Domain\Core\Enums\GameStateEnum;
use Domain\Core\Models\Game;
use Domain\Core\Models\Player;
use Domain\Users\Builders\UserBuilder;
use Domain\Users\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\Model;

class PlayersRelationManager extends RelationManager
{
    protected static string $relationship = 'players';

    protected static ?string $recordTitleAttribute = 'player_id';

    public static function getModelLabel(): string
    {
        return __('core/player.name_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('core/player.name_singular');
    }

    protected $listeners = [
        'filament.ludomaniac.game.finish' => '$refresh',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        $gameFinishedCallback = function (self $livewire) {
            /** @var Game $game */
            $game = $livewire->getOwnerRecord();

            return $game->currentState() === GameStateEnum::FINISHED;
        };

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rank')
                    ->label(__('core/player.attributes.rank'))
                    ->sortable()
                    ->visible($gameFinishedCallback),
                Tables\Columns\TextColumn::make('power.name')
                    ->label(__('core/player.attributes.power')),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('users/user.name_singular'))->default('Kein Nutzer zugewiesen'),
                Tables\Columns\TextColumn::make('nmr_count')
                    ->label(__('core/player.attributes.nmr_count'))
                    ->color(fn (Model $record) => $record->nmr_count > 2 ? 'danger' : ''),
                TextInputColumn::make('sc_count')
                    ->label(__('core/player.attributes.sc_count'))
                    ->type('number')
                    ->rules(['integer', 'min:0'])
                    ->hidden($gameFinishedCallback),
                Tables\Columns\TextColumn::make('sc_count_alternative')
                    ->label(__('core/player.attributes.sc_count'))
                    ->visible($gameFinishedCallback)
                    ->getStateUsing(fn (Player $record) => $record->sc_count),
            ])
            ->defaultSort('rank')
            ->filters([

            ])
            ->headerActions([

            ])
            ->actions([
                Tables\Actions\Action::make('nmr')
                    ->action(fn (Model $record, AddNMRForPlayerAction $actor) => $actor->execute($record))
                    ->label(__('core/player.actions.nmr'))
                    ->visible(function (Model $record) {
                        return $record->game->currentState() === GameStateEnum::STARTED && $record->user_id !== null;
                    })
                    ->hidden($gameFinishedCallback)
                    ->icon('heroicon-o-plus')
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('ban')
                    ->label(__('core/player.actions.ban'))
                    ->action(function (RelationManager $livewire, Model $record) {
                        /** @var Player $player */
                        $player = $record;
                        /** @var BanUserFromGameAction $action */
                        $action = app(BanUserFromGameAction::class);
                        $action->execute($player);
                    })
                    ->hidden($gameFinishedCallback)
                    ->visible(fn (Model $record) => $record->canBeBanned())
                    ->icon('heroicon-s-ban')
                    ->color('danger')
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('Assign user')
                    ->label(__('core/player.actions.assign'))
                    ->modalHeading(__('core/player.assign_users.title'))
                    ->hidden($gameFinishedCallback)
                    ->form(function (RelationManager $livewire) {
                        /** @var Game $game */
                        $game = $livewire->getOwnerRecord();

                        return [
                            Forms\Components\Select::make('user_id')
                                ->label(__('users/user.name_plural'))
                                ->options(
                                    fn (callable $get) => User::query()
                                        ->when(
                                            ! $get('show_all_users'),
                                            fn (UserBuilder $query) => $query->whereSignedUpForGame($game->id)
                                        )
                                        ->whereNotPlayingInGame($game->id)
                                        ->pluck('name', 'id')
                                )
                                ->required()
                                ->searchable(),
                            Forms\Components\Toggle::make('show_all_users')
                                ->label(__('core/player.assign_users.show_all_users'))
                                ->hint(__('core/player.assign_users.show_all_users_hint'))
                                ->offIcon('heroicon-s-eye-off')
                                ->onIcon('heroicon-s-eye')
                                ->reactive(),
                        ];
                    })
                    ->action(function (array $data, Model $record) {
                        /** @var Player $record */
                        $action = app(AssignUserToGameAction::class);
                        $action->execute($record, User::find($data['user_id']));
                    })
                    ->visible(fn (Model $record) => $record->canAcceptPlayer()),
            ])
            ->bulkActions([

            ]);
    }
}
