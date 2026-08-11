<?php

namespace App\Filament\Resources\VillageEvents\Pages;

use App\Filament\Resources\VillageEvents\VillageEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageVillageEvents extends ManageRecords
{
    protected static string $resource = VillageEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
