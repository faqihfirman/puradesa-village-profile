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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

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
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, callable $set) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->helperText('Tidak berubah otomatis saat judul diedit. Ubah manual hanya jika benar-benar perlu.')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->helperText('Tampil di kartu daftar UMKM.')
                    ->required()
                    ->rows(3),
                Textarea::make('content')
                    ->label('Deskripsi Lengkap')
                    ->helperText('Tampil di halaman detail. Kosongkan untuk memakai Deskripsi Singkat.')
                    ->rows(6),
                Select::make('sector')
                    ->label('Sektor / Golongan')
                    ->helperText('Ikon di kartu & halaman detail otomatis mengikuti sektor ini.')
                    ->options(EconomicPotential::SECTORS)
                    ->required(),
                FileUpload::make('image_path')
                    ->label('Gambar')
                    ->helperText('Opsional, ukuran disarankan 800×600 px.')
                    ->image()
                    ->disk('uploads')
                    ->directory('economic-potentials'),
                TextInput::make('maps_url')
                    ->label('Link Google Maps')
                    ->helperText('Tautan lokasi usaha di Google Maps. Kosongkan bila belum ada.')
                    ->url()
                    ->maxLength(255),
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
                TextColumn::make('sector_label')
                    ->label('Sektor')
                    ->badge(),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                SelectFilter::make('sector')
                    ->label('Sektor')
                    ->options(EconomicPotential::SECTORS),
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
