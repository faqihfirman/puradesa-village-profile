<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
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

class ManageSiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Kontak & Jam Layanan')
                    ->schema([
                        TextInput::make('address')
                            ->label('Alamat Kantor')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel()
                            ->required(),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->tel(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        TextInput::make('office_hours_weekday')
                            ->label('Jam Layanan Hari Kerja')
                            ->helperText('Contoh: Senin–Jumat, 08.00–15.00 WIB')
                            ->required(),
                        TextInput::make('office_hours_weekend')
                            ->label('Jam Layanan Akhir Pekan')
                            ->helperText('Contoh: Sabtu–Minggu, Tutup')
                            ->required(),
                    ])
                    ->columns(2),
                Section::make('Lokasi Kantor')
                    ->schema([
                        TextInput::make('office_lat')
                            ->label('Latitude')
                            ->numeric()
                            ->required(),
                        TextInput::make('office_lng')
                            ->label('Longitude')
                            ->numeric()
                            ->required(),
                        TextInput::make('google_maps_url')
                            ->label('Tautan Google Maps')
                            ->url()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Media Sosial')
                    ->schema([
                        TextInput::make('facebook_url')->label('Facebook')->url(),
                        TextInput::make('instagram_url')->label('Instagram')->url(),
                        TextInput::make('youtube_url')->label('YouTube')->url(),
                    ])
                    ->columns(3),
                Section::make('Foto Hero Beranda')
                    ->schema([
                        FileUpload::make('hero_image_path')
                            ->label('Foto Hero')
                            ->helperText('Ukuran gambar disarankan 1920×1080 px. Ini foto latar utama di halaman Beranda.')
                            ->image()
                            ->disk('uploads')
                            ->directory('site')
                            ->automaticallyResizeImagesToWidth(1920)
                            ->automaticallyResizeImagesToHeight(1080)
                            ->automaticallyResizeImagesMode('cover'),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([$this->getFormContentComponent()]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make([
                    Action::make('save')->label('Simpan')->submit('save'),
                ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        SiteSetting::current()->update($data);

        Notification::make()
            ->title('Pengaturan situs berhasil disimpan')
            ->success()
            ->send();
    }
}
