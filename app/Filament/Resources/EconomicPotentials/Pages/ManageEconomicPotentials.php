<?php

namespace App\Filament\Resources\EconomicPotentials\Pages;

use App\Filament\Resources\EconomicPotentials\EconomicPotentialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageEconomicPotentials extends ManageRecords
{
    protected static string $resource = EconomicPotentialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
