<?php

namespace App\Filament\Pages;

use App\Models\VillageProfile;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageVillageProfile extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static string|\UnitEnum|null $navigationGroup = 'Profil Desa';

    protected static ?string $navigationLabel = 'Data Profil';

    protected static ?string $title = 'Data Profil Desa';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(VillageProfile::current()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Sejarah')
                    ->schema([
                        TextInput::make('founded_year')
                            ->label('Tahun Berdiri')
                            ->numeric()
                            ->required(),
                        RichEditor::make('history_content')
                            ->label('Sejarah Desa')
                            ->helperText('Disarankan minimal 600 kata untuk kebutuhan SEO.')
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('illustration_path')
                            ->label('Ilustrasi/Peta Wilayah')
                            ->image()
                            ->disk('uploads')
                            ->directory('site'),
                    ])
                    ->columns(2),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make([
                    Action::make('save')
                        ->label('Simpan')
                        ->submit('save'),
                ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        VillageProfile::current()->update($data);

        Notification::make()
            ->title('Data profil desa berhasil disimpan')
            ->success()
            ->send();
    }
}
