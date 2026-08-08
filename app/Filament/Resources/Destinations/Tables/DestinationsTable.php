<?php

namespace App\Filament\Resources\Destinations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DestinationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_url')
                    ->label('Sampul')
                    ->disk(null)
                    ->square(),
                TextColumn::make('name')
                    ->label('Nama Destinasi')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => \App\Models\Destination::CATEGORY_LABELS[$state] ?? $state),
                TextColumn::make('hamlet_name')
                    ->label('Dusun'),
                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'wisata_alam' => 'Wisata Alam',
                        'wisata_budaya' => 'Wisata Budaya',
                        'agrowisata' => 'Agrowisata',
                        'wisata_buatan' => 'Wisata Buatan',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
