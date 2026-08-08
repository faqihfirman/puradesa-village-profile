<?php

namespace App\Filament\Resources\Officials;

use App\Filament\Resources\Officials\Pages\ManageOfficials;
use App\Models\Official;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OfficialResource extends Resource
{
    protected static ?string $model = Official::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|\UnitEnum|null $navigationGroup = 'Profil Desa';

    protected static ?string $navigationLabel = 'Perangkat Desa';

    protected static ?string $modelLabel = 'perangkat desa';

    protected static ?string $pluralModelLabel = 'perangkat desa';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('position')
                    ->label('Jabatan')
                    ->required()
                    ->maxLength(255),
                Select::make('level')
                    ->label('Tingkat Hierarki')
                    ->options(Official::LEVEL_LABELS)
                    ->required()
                    ->helperText('Menentukan posisi di struktur organisasi (SOTK).'),
                TextInput::make('phone')
                    ->label('Nomor Kontak Dinas')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('period_start')
                    ->label('Awal Periode')
                    ->numeric()
                    ->maxLength(4),
                TextInput::make('period_end')
                    ->label('Akhir Periode')
                    ->numeric()
                    ->maxLength(4),
                Toggle::make('is_active')
                    ->label('Masih Menjabat')
                    ->default(true),
                FileUpload::make('photo_path')
                    ->label('Foto')
                    ->helperText('Foto potret rasio 3:4, akan otomatis dipotong dan diubah ke 600×800 px.')
                    ->image()
                    ->disk('uploads')
                    ->directory('officials')
                    ->imageEditor()
                    ->imageAspectRatio('3:4')
                    ->automaticallyCropImagesToAspectRatio()
                    ->automaticallyResizeImagesToWidth(600)
                    ->automaticallyResizeImagesToHeight(800),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo_url')
                    ->label('Foto')
                    ->disk(null)
                    ->circular(),
                TextColumn::make('name')->label('Nama')->searchable(),
                TextColumn::make('position')->label('Jabatan'),
                IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->groups(['level'])
            ->defaultGroup('level')
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
            'index' => ManageOfficials::route('/'),
        ];
    }
}
