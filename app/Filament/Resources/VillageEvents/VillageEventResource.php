<?php

namespace App\Filament\Resources\VillageEvents;

use App\Filament\Resources\VillageEvents\Pages\ManageVillageEvents;
use App\Models\VillageEvent;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VillageEventResource extends Resource
{
    protected static ?string $model = VillageEvent::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = 'Konten';

    protected static ?string $navigationLabel = 'Kalender Desa';

    protected static ?string $modelLabel = 'kegiatan';

    protected static ?string $pluralModelLabel = 'kegiatan';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kegiatan')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),
                TimePicker::make('start_time')
                    ->label('Waktu Mulai')
                    ->seconds(false),
                TimePicker::make('end_time')
                    ->label('Waktu Selesai')
                    ->seconds(false)
                    ->after('start_time'),
                TextInput::make('location')
                    ->label('Tempat')
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->label('Tanggal')->date('d M Y'),
                TextColumn::make('name')->label('Nama Kegiatan'),
                TextColumn::make('start_time')->label('Waktu')->time('H:i')->placeholder('—'),
                TextColumn::make('location')->label('Tempat')->placeholder('—'),
            ])
            ->defaultSort('date')
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
            'index' => ManageVillageEvents::route('/'),
        ];
    }
}
