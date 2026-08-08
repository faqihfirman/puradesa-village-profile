<?php

namespace App\Filament\Resources\Hamlets;

use App\Filament\Resources\Hamlets\Pages\ManageHamlets;
use App\Models\Hamlet;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HamletResource extends Resource
{
    protected static ?string $model = Hamlet::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static string|\UnitEnum|null $navigationGroup = 'Profil Desa';

    protected static ?string $navigationLabel = 'Data Dusun';

    protected static ?string $modelLabel = 'dusun';

    protected static ?string $pluralModelLabel = 'dusun';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Dusun')
                    ->required()
                    ->maxLength(255),
                TextInput::make('population')
                    ->label('Jumlah Jiwa')
                    ->numeric()
                    ->required(),
                TextInput::make('families')
                    ->label('Jumlah KK')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Dusun'),
                TextColumn::make('population')->label('Jumlah Jiwa')->numeric(),
                TextColumn::make('families')->label('Jumlah KK')->numeric(),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHamlets::route('/'),
        ];
    }
}
