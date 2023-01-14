<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers\PlayersRelationManager;
use App\Filament\Resources\GameResource\RelationManagers\SignedUpUsersRelationManager;
use Domain\Core\Models\Game;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Spielleiter';

    public static function getModelLabel(): string
    {
        return __('core/game.name_singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('core/game.name_plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('core/game.attributes.name'))
                    ->required()
                    ->disabledOn('edit')
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('variant_id')
                    ->label(__('core/variant.name_singular'))
                    ->relationship('variant', 'name')
                    ->required()
                    ->disabledOn('edit')
                    ->dehydrated(fn (Page $livewire) => $livewire instanceof CreateRecord),
                Forms\Components\MarkdownEditor::make('description')
                    ->label(__('core/game.attributes.description'))
                    ->disableToolbarButtons([
                        'attachFiles',
                        'codeBlock',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('variant.name'),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PlayersRelationManager::class,
            SignedUpUsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'view' => Pages\ViewGame::route('/{record}'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
