<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Destination extends Model
{
    const CATEGORY_LABELS = [
        'wisata_alam' => 'Wisata Alam',
        'wisata_budaya' => 'Wisata Budaya',
        'agrowisata' => 'Agrowisata',
        'wisata_buatan' => 'Wisata Buatan',
    ];

    protected $fillable = [
        'name', 'slug', 'category', 'short_description', 'description',
        'cover_path', 'gallery', 'hamlet_name', 'latitude', 'longitude',
        'visiting_hours', 'entrance_fee', 'manager_name', 'manager_phone',
        'meta_description', 'is_featured', 'order',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_featured' => 'boolean',
        ];
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_path
            ? Storage::disk('uploads')->url($this->cover_path)
            : null;
    }

    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->gallery ?? [])
            ->map(fn (string $path) => Storage::disk('uploads')->url($path))
            ->all();
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORY_LABELS[$this->category] ?? $this->category;
    }
}
