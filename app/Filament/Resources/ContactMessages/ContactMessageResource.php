<?php

namespace App\Filament\Resources\ContactMessages;

use App\Filament\Resources\ContactMessages\Pages\ManageContactMessages;
use App\Models\ContactMessage;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static string|\UnitEnum|null $navigationGroup = 'Interaksi';

    protected static ?string $navigationLabel = 'Pesan Masuk';

    protected static ?string $modelLabel = 'pesan';

    protected static ?string $pluralModelLabel = 'pesan masuk';

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::unread()->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_read')
                    ->label('Dibaca')
                    ->boolean(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('Dikirim')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Status Baca')
                    ->trueLabel('Sudah dibaca')
                    ->falseLabel('Belum dibaca'),
            ])
            ->recordActions([
                Action::make('markAsRead')
                    ->label('Tandai Dibaca')
                    ->icon('heroicon-o-check')
                    ->visible(fn (ContactMessage $record) => ! $record->is_read)
                    ->action(fn (ContactMessage $record) => $record->update(['is_read' => true, 'read_at' => now()])),
                Action::make('reply')
                    ->label('Balas')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->url(fn (ContactMessage $record) => 'mailto:'.$record->email)
                    ->openUrlInNewTab(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageContactMessages::route('/'),
        ];
    }
}
