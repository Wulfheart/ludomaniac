<?php

namespace App\Filament\Resources\GameResource\RelationManagers;

use Domain\Core\Actions\AssignUserToGameAction;
use Domain\Core\Actions\BanUserFromGameAction;
use Domain\Core\Models\Game;
use Domain\Core\Models\Player;
use Domain\Users\Builders\UserBuilder;
use Domain\Users\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class PlayersRelationManager extends RelationManager
{
    protected static string $relationship = 'players';

    protected static ?string $recordTitleAttribute = 'player_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('power.name'),
                Tables\Columns\TextColumn::make('user.name')->default('Kein Nutzer zugewiesen'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('ban')
                    ->action(function (RelationManager $livewire, Model $record) {
                        /** @var Player $player */
                        $player = $record;
                        /** @var BanUserFromGameAction $action */
                        $action = app(BanUserFromGameAction::class);
                        $action->execute($player);
                    })
                    ->visible(fn (Model $record) => $record->canBeBanned())
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('Assign user')
                    ->form(function (RelationManager $livewire) {
                        /** @var Game $game */
                        $game = $livewire->getOwnerRecord();

                        return [
                            Forms\Components\Select::make('user_id')
                                ->options(fn (callable $get) => User::query()
                                    ->when(! $get('show_all_users'),
                                        fn (UserBuilder $query) => $query->whereSignedUpForGame($game->id)
                                    )
                                    ->whereNotPlayingInGame($game->id)
                                    ->pluck('name', 'id')
                                )
                                ->required()
                                ->searchable(),
                            Forms\Components\Toggle::make('show_all_users')
                                ->hint('Show all users, even if they have not signed up for this game')
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
