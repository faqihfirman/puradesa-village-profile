<?php

namespace App\Filament\Resources\Missions\Pages;

use App\Filament\Resources\Missions\MissionResource;
use App\Models\VillageProfile;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\RenderHook;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\View\PanelsRenderHook;

class ManageMissions extends ManageRecords
{
    protected static string $resource = MissionResource::class;

    public ?array $visionData = [];

    public function mount(): void
    {
        parent::mount();

        $this->visionForm->fill([
            'vision' => VillageProfile::current()->vision,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function visionForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('visionData')
            ->components([
                Textarea::make('vision')
                    ->label('Visi')
                    ->required()
                    ->rows(3),
            ]);
    }

    public function saveVision(): void
    {
        VillageProfile::current()->update($this->visionForm->getState());

        Notification::make()
            ->title('Visi berhasil disimpan')
            ->success()
            ->send();
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Visi')
                    ->schema([
                        Form::make([EmbeddedSchema::make('visionForm')])
                            ->id('visionForm')
                            ->livewireSubmitHandler('saveVision')
                            ->footer([
                                Actions::make([
                                    Action::make('saveVision')
                                        ->label('Simpan Visi')
                                        ->submit('saveVision'),
                                ]),
                            ]),
                    ]),
                $this->getTabsContentComponent(),
                RenderHook::make(PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE),
                EmbeddedTable::make(),
                RenderHook::make(PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_AFTER),
            ]);
    }
}
