<?php

namespace App\Filament\Resources\GameResource\RelationManagers;

use Domain\Core\Models\Game;
use Domain\Users\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class SignedUpUsersRelationManager extends RelationManager
{
    protected static string $relationship = 'signedUpUsers';

    protected static ?string $recordTitleAttribute = 'name';

    protected $listeners = [
        'filament.ludomaniac.game.finish' => '$refresh',
    ];

    public static function getModelLabel(): string
    {
        return __('core/game_signed_up_user.name_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('core/game_signed_up_user.name_plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(function (RelationManager $livewire) {
                /** @var Game $game */
                $game = $livewire->getOwnerRecord();

                return [
                    Forms\Components\Select::make('user_id')
                        ->label(__('users/user.name_singular'))
                        ->options(function () use ($game) {
                            return User::query()
                                ->whereNotSignedUpForGame($game->id)
                                ->whereNotPlayingInGame($game->id)
                                ->pluck('name', 'id');
                        })
                        ->searchable()
                        ->required(),
                ];
            });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('users/user.name_singular'))
                    //->url(fn (Model $record) => 'https://zeit.de')
                    ->openUrlInNewTab(),
            ])
            ->filters([

            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->hidden(fn (self $livewire) => $livewire->getOwnerRecord()->signedUpUsers()->count() >= 7),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()->label(__('core/game_signed_up_user.actions.remove')),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
