<?php

namespace App\Filament\Resources\GameResource\RelationManagers;

use Domain\Core\Actions\AssignUserToGameAction;
use Domain\Core\Actions\BanUserFromGameAction;
use Domain\Core\Models\Game;
use Domain\Core\Models\Player;
use Domain\Users\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Tables\Columns\TextColumn::make('user.name')->default("Kein Nutzer zugewiesen"),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('ban')
                    ->action(function (RelationManager $livewire) {
                        dd($livewire->getOwnerRecord());
                        /** @var BanUserFromGameAction $action */
                        $action = app(BanUserFromGameAction::class);
                        $action->execute($player);
                    })
                    //->visible(fn(Player $player) => $player->canBeBanned())
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('Assign user')
                    ->form(function (RelationManager $livewire) {
                        /** @var Game $game */
                        $game = $livewire->getOwnerRecord();
                        return [
                            Forms\Components\Select::make('user_id')
                                ->options(function () use ($game){
                                    return User::query()->whereNotPlayingInGame($game->id)->pluck('name', 'id');
                                })
                                ->required(),
                            Forms\Components\Hidden::make('player_id'),
                        ];
                    })
                    ->action(function (array $data, Player $player) {
                        dd($data, $player);
                        /** @var AssignUserToGameAction $action */
                        $action = app(AssignUserToGameAction::class);
                        $action->execute($player, User::find($data['user_id']));
                    })
                    ->visible(fn(Player $player) => $player->canAcceptPlayer())

                ,
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
