<?php

namespace App\Filament\Pages;

use App\Models\VillageHeadMessage;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;

class ManageVillageHeadMessage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|\UnitEnum|null $navigationGroup = 'Profil Desa';

    protected static ?string $navigationLabel = 'Sambutan Kepala Desa';

    protected static ?string $title = 'Sambutan Kepala Desa';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function mount(): void
    {
        $this->form->fill(VillageHeadMessage::current()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                TextInput::make('name')
                    ->label('Nama Kepala Desa')
                    ->required()
                    ->maxLength(255),
                TextInput::make('position')
                    ->label('Jabatan')
                    ->default('Kepala Desa')
                    ->required()
                    ->maxLength(255),
                Textarea::make('message')
                    ->label('Isi Sambutan')
                    ->required()
                    ->rows(6)
                    ->columnSpanFull(),
                FileUpload::make('photo_path')
                    ->label('Foto')
                    ->helperText('Ukuran gambar disarankan 600×600 px (rasio 1:1).')
                    ->image()
                    ->disk('uploads')
                    ->directory('village-head')
                    ->imageEditor()
                    ->imageAspectRatio('1:1')
                    ->automaticallyCropImagesToAspectRatio()
                    ->automaticallyResizeImagesToWidth(600)
                    ->automaticallyResizeImagesToHeight(600),
            ])
            ->columns(2);
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
        $message = VillageHeadMessage::current();
        $data = $this->form->getState();

        if ($message->photo_path && $message->photo_path !== ($data['photo_path'] ?? null)) {
            Storage::disk('uploads')->delete($message->photo_path);
        }

        $message->update($data);

        Notification::make()
            ->title('Sambutan kepala desa berhasil disimpan')
            ->success()
            ->send();
    }
}
