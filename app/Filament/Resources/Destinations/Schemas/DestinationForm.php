<?php

namespace App\Filament\Resources\Destinations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DestinationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Destinasi')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Destinasi')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->helperText('Tidak berubah otomatis saat nama diedit. Ubah manual hanya jika benar-benar perlu.')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Textarea::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->helperText('Tampil di kartu daftar destinasi. Maksimal 200 karakter.')
                            ->required()
                            ->maxLength(200)
                            ->rows(2),
                        RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->helperText('Ceritakan daya tarik, sejarah/latar, dan aktivitas yang bisa dilakukan. Disarankan minimal 300 kata untuk SEO.')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Kategori & Lokasi')
                    ->columnSpan(1)
                    ->schema([
                        Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'wisata_alam' => 'Wisata Alam',
                                'wisata_budaya' => 'Wisata Budaya',
                                'agrowisata' => 'Agrowisata',
                                'wisata_buatan' => 'Wisata Buatan',
                            ])
                            ->required(),
                        TextInput::make('hamlet_name')
                            ->label('Dusun')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->required(),
                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->required(),
                        Toggle::make('is_featured')
                            ->label('Jadikan Destinasi Unggulan'),
                    ]),
                Section::make('Informasi Kunjungan')
                    ->columnSpan(1)
                    ->description('Semua field opsional — kosongkan jika belum ada info.')
                    ->schema([
                        TextInput::make('visiting_hours')
                            ->label('Jam Kunjungan')
                            ->maxLength(255),
                        TextInput::make('entrance_fee')
                            ->label('Tiket / Kontribusi')
                            ->maxLength(255),
                        TextInput::make('manager_name')
                            ->label('Nama Pengelola')
                            ->maxLength(255),
                        TextInput::make('manager_phone')
                            ->label('Kontak Pengelola')
                            ->tel()
                            ->maxLength(255),
                    ]),
                Section::make('Gambar')
                    ->columnSpan(2)
                    ->schema([
                        FileUpload::make('cover_path')
                            ->label('Sampul Destinasi')
                            ->helperText('Ukuran gambar disarankan 1200×800 px.')
                            ->image()
                            ->disk('uploads')
                            ->directory('destinations/covers')
                            ->automaticallyResizeImagesToWidth(1200)
                            ->automaticallyResizeImagesToHeight(800)
                            ->automaticallyResizeImagesMode('cover'),
                        FileUpload::make('gallery')
                            ->label('Galeri Foto')
                            ->helperText('Bisa unggah beberapa foto sekaligus.')
                            ->image()
                            ->multiple()
                            ->disk('uploads')
                            ->directory('destinations/gallery')
                            ->reorderable(),
                    ]),
                Section::make('SEO')
                    ->columnSpan(2)
                    ->schema([
                        Textarea::make('meta_description')
                            ->label('Deskripsi Meta (SEO)')
                            ->helperText('Maksimal 160 karakter. Kosongkan untuk memakai Deskripsi Singkat.')
                            ->maxLength(160)
                            ->rows(2),
                    ]),
            ])
            ->columns(3);
    }
}
