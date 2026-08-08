<?php

namespace App\Filament\Resources\Officials\Pages;

use App\Filament\Resources\Officials\OfficialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageOfficials extends ManageRecords
{
    protected static string $resource = OfficialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
