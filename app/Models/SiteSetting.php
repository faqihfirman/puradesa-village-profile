<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'address', 'phone', 'whatsapp', 'email',
        'office_hours_weekday', 'office_hours_weekend',
        'office_lat', 'office_lng', 'google_maps_url',
        'facebook_url', 'instagram_url', 'youtube_url',
        'hero_image_path',
    ];

    protected function casts(): array
    {
        return [
            'office_lat' => 'decimal:7',
            'office_lng' => 'decimal:7',
        ];
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->hero_image_path
            ? Storage::disk('uploads')->url($this->hero_image_path)
            : null;
    }

    public static function current(): self
    {
        return static::first() ?? static::create([
            'address' => '', 'phone' => '', 'email' => '',
            'office_hours_weekday' => '', 'office_hours_weekend' => '',
            'office_lat' => 0, 'office_lng' => 0,
        ]);
    }
}
