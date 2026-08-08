<?php

namespace App\Filament\Pages;

use App\Models\VillageProfile;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
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
                Section::make('Sejarah & Visi')
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
                        Textarea::make('vision')
                            ->label('Visi')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('illustration_path')
                            ->label('Ilustrasi/Peta Wilayah')
                            ->image()
                            ->disk('uploads')
                            ->directory('site'),
                    ])
                    ->columns(2),
                Section::make('Data Geografis')
                    ->schema([
                        TextInput::make('area_size')
                            ->label('Luas Wilayah')
                            ->numeric()
                            ->required(),
                        TextInput::make('area_unit')
                            ->label('Satuan Luas')
                            ->default('Ha')
                            ->required(),
                        TextInput::make('altitude')
                            ->label('Ketinggian')
                            ->numeric()
                            ->required(),
                        TextInput::make('altitude_unit')
                            ->label('Satuan Ketinggian')
                            ->default('Mdpl')
                            ->required(),
                        TextInput::make('boundary_north')
                            ->label('Batas Utara'),
                        TextInput::make('boundary_south')
                            ->label('Batas Selatan'),
                        TextInput::make('boundary_east')
                            ->label('Batas Timur'),
                        TextInput::make('boundary_west')
                            ->label('Batas Barat'),
                    ])
                    ->columns(4),
                Section::make('Demografi & Peta')
                    ->schema([
                        TextInput::make('total_population')
                            ->label('Total Penduduk')
                            ->numeric()
                            ->required(),
                        TextInput::make('total_families')
                            ->label('Total Kepala Keluarga')
                            ->numeric()
                            ->required(),
                        TextInput::make('total_hamlets')
                            ->label('Jumlah Dusun')
                            ->numeric()
                            ->required(),
                        TextInput::make('map_center_lat')
                            ->label('Latitude Pusat Peta')
                            ->numeric()
                            ->required(),
                        TextInput::make('map_center_lng')
                            ->label('Longitude Pusat Peta')
                            ->numeric()
                            ->required(),
                        TextInput::make('map_zoom')
                            ->label('Level Zoom Peta')
                            ->numeric()
                            ->default(14)
                            ->required(),
                    ])
                    ->columns(3),
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
