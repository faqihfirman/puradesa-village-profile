<?php

namespace App\Filament\Resources\Hamlets\Pages;

use App\Filament\Resources\Hamlets\HamletResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageHamlets extends ManageRecords
{
    protected static string $resource = HamletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
