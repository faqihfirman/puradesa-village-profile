<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VillageProfile extends Model
{
    protected $fillable = [
        'history_content', 'founded_year', 'illustration_path', 'vision',
        'area_size', 'area_unit', 'altitude', 'altitude_unit',
        'boundary_north', 'boundary_south', 'boundary_east', 'boundary_west',
        'total_population', 'total_families', 'total_hamlets',
        'map_center_lat', 'map_center_lng', 'map_zoom',
    ];

    protected function casts(): array
    {
        return [
            'area_size' => 'decimal:2',
            'map_center_lat' => 'decimal:7',
            'map_center_lng' => 'decimal:7',
        ];
    }

    public function getIllustrationUrlAttribute(): ?string
    {
        return $this->illustration_path
            ? Storage::disk('uploads')->url($this->illustration_path)
            : null;
    }

    public static function current(): self
    {
        return static::first() ?? static::create([
            'history_content' => '', 'founded_year' => now()->year,
            'vision' => '', 'area_size' => 0, 'altitude' => 0,
            'total_population' => 0, 'total_families' => 0, 'total_hamlets' => 0,
            'map_center_lat' => 0, 'map_center_lng' => 0,
        ]);
    }
}
