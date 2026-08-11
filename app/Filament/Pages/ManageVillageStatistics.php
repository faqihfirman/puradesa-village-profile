<?php

namespace App\Filament\Pages;

use App\Models\VillageProfile;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageVillageStatistics extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|\UnitEnum|null $navigationGroup = 'Profil Desa';

    protected static ?string $navigationLabel = 'Data Wilayah';

    protected static ?string $title = 'Data Wilayah & Demografi';

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
                Section::make('Data Wilayah')
                    ->description('Semua data kondisi wilayah, kependudukan, dan peta dikelola di satu tempat ini.')
                    ->schema([
                        Fieldset::make('Kondisi Umum Wilayah')
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
                                TextInput::make('total_families')
                                    ->label('Jumlah Keluarga')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('total_population')
                                    ->label('Jumlah Penduduk')
                                    ->numeric()
                                    ->required()
                                    ->helperText('Kepadatan penduduk dihitung otomatis dari jumlah penduduk dibagi luas wilayah.'),
                            ])
                            ->columns(3),

                        Fieldset::make('Penduduk Berdasarkan Agama')
                            ->schema([
                                Repeater::make('population_by_religion')
                                    ->label('')
                                    ->schema([
                                        TextInput::make('label')->label('Agama')->required(),
                                        TextInput::make('total')->label('Jumlah')->numeric()->required()->default(0),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel('Tambah Agama')
                                    ->reorderable(false)
                                    ->columnSpanFull(),
                            ]),

                        Fieldset::make('Penduduk Berdasarkan Status Perkawinan')
                            ->schema([
                                Repeater::make('population_by_marital_status')
                                    ->label('')
                                    ->schema([
                                        TextInput::make('label')->label('Status')->required(),
                                        TextInput::make('total')->label('Jumlah')->numeric()->required()->default(0),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel('Tambah Status')
                                    ->reorderable(false)
                                    ->columnSpanFull(),
                            ]),

                        Fieldset::make('Pendidikan Penduduk')
                            ->schema([
                                Repeater::make('population_by_education')
                                    ->label('')
                                    ->schema([
                                        TextInput::make('label')->label('Jenjang')->required(),
                                        TextInput::make('male')->label('Laki-laki')->numeric()->required()->default(0),
                                        TextInput::make('female')->label('Perempuan')->numeric()->required()->default(0),
                                    ])
                                    ->columns(3)
                                    ->addActionLabel('Tambah Jenjang')
                                    ->reorderable(false)
                                    ->columnSpanFull(),
                            ]),

                        Fieldset::make('Pekerjaan Penduduk')
                            ->schema([
                                Repeater::make('population_by_occupation')
                                    ->label('')
                                    ->schema([
                                        TextInput::make('label')->label('Pekerjaan')->required(),
                                        TextInput::make('male')->label('Laki-laki')->numeric()->required()->default(0),
                                        TextInput::make('female')->label('Perempuan')->numeric()->required()->default(0),
                                    ])
                                    ->columns(3)
                                    ->addActionLabel('Tambah Pekerjaan')
                                    ->reorderable(false)
                                    ->columnSpanFull(),
                            ]),

                        Fieldset::make('Usia Penduduk')
                            ->schema([
                                Repeater::make('population_by_age_group')
                                    ->label('')
                                    ->schema([
                                        TextInput::make('label')->label('Rentang Usia')->required(),
                                        TextInput::make('male')->label('Laki-laki')->numeric()->required()->default(0),
                                        TextInput::make('female')->label('Perempuan')->numeric()->required()->default(0),
                                    ])
                                    ->columns(3)
                                    ->addActionLabel('Tambah Rentang Usia')
                                    ->reorderable(false)
                                    ->columnSpanFull(),
                            ]),

                        Fieldset::make('Peta')
                            ->schema([
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
                    ]),
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
            ->title('Data wilayah berhasil disimpan')
            ->success()
            ->send();
    }
}
