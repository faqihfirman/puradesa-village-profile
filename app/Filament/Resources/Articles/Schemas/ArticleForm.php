<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Artikel')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
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
                            ->helperText('Tidak berubah otomatis saat judul diedit. Ubah manual hanya jika benar-benar perlu — link lama akan mati.')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Textarea::make('excerpt')
                            ->label('Ringkasan')
                            ->helperText('Tampil di kartu daftar artikel. Maksimal 300 karakter.')
                            ->required()
                            ->maxLength(300)
                            ->rows(3),
                        RichEditor::make('content')
                            ->label('Isi Artikel')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Publikasi')
                    ->columnSpan(1)
                    ->schema([
                        Radio::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draf',
                                'published' => 'Terbit',
                            ])
                            ->default('draft')
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Terbit')
                            ->helperText('Kosongkan untuk memakai waktu saat ini ketika status diubah ke Terbit.'),
                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('author_name')
                            ->label('Nama Penulis')
                            ->default('Admin Desa')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_featured')
                            ->label('Jadikan Artikel Unggulan'),
                    ]),
                Section::make('Gambar Sampul')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('cover_path')
                            ->label('Sampul Artikel')
                            ->helperText('Ukuran gambar disarankan 1600×900 px. Format akan dikonversi otomatis ke WebP.')
                            ->image()
                            ->disk('uploads')
                            ->directory('articles/covers')
                            ->automaticallyResizeImagesToWidth(1600)
                            ->automaticallyResizeImagesToHeight(900)
                            ->automaticallyResizeImagesMode('cover'),
                    ]),
                Section::make('SEO')
                    ->columnSpan(1)
                    ->schema([
                        Textarea::make('meta_description')
                            ->label('Deskripsi Meta (SEO)')
                            ->helperText('Maksimal 160 karakter. Kosongkan untuk memakai Ringkasan.')
                            ->maxLength(160)
                            ->rows(2),
                    ]),
            ])
            ->columns(3);
    }
}
