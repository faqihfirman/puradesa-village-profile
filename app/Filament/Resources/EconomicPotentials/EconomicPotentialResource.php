<?php

namespace App\Filament\Resources\EconomicPotentials;

use App\Filament\Resources\EconomicPotentials\Pages\ManageEconomicPotentials;
use App\Models\EconomicPotential;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EconomicPotentialResource extends Resource
{
    protected static ?string $model = EconomicPotential::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static string|\UnitEnum|null $navigationGroup = 'Potensi Desa';

    protected static ?string $navigationLabel = 'Potensi Ekonomi';

    protected static ?string $modelLabel = 'potensi ekonomi';

    protected static ?string $pluralModelLabel = 'potensi ekonomi';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(3),
                TextInput::make('icon')
                    ->label('Nama Ikon (Lucide)')
                    ->helperText('Isi nama ikon dari lucide.dev, mis. "wheat" atau "fish".')
                    ->required()
                    ->maxLength(255),
                TagsInput::make('tags')
                    ->label('Tag')
                    ->helperText('Contoh: Padi Menthik, Sayur Mayur.'),
                FileUpload::make('image_path')
                    ->label('Gambar')
                    ->helperText('Opsional, ukuran disarankan 800×600 px.')
                    ->image()
                    ->disk('uploads')
                    ->directory('economic-potentials'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->disk(null)
                    ->square(),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                TextColumn::make('tags')
                    ->label('Tag')
                    ->badge(),
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
            'index' => ManageEconomicPotentials::route('/'),
        ];
    }
}
