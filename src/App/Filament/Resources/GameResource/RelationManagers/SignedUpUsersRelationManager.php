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

    public static function form(Form $form): Form
    {
        return $form
            ->schema(function (RelationManager $livewire) {
                /** @var Game $game */
                $game = $livewire->getOwnerRecord();

                return [
                    Forms\Components\Select::make('user_id')
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
                    ->url(fn (Model $record) => 'https://zeit.de')
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()->label('Remove'),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
