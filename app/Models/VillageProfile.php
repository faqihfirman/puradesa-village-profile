<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VillageProfile extends Model
{
    protected $fillable = [
        'history_content', 'founded_year', 'illustration_path', 'vision',
        'area_size', 'area_unit', 'altitude', 'altitude_unit',
        'total_population', 'total_families',
        'population_by_religion', 'population_by_marital_status',
        'population_by_education', 'population_by_occupation', 'population_by_age_group',
        'map_center_lat', 'map_center_lng', 'map_zoom',
    ];

    protected function casts(): array
    {
        return [
            'area_size' => 'decimal:2',
            'map_center_lat' => 'decimal:7',
            'map_center_lng' => 'decimal:7',
            'population_by_religion' => 'array',
            'population_by_marital_status' => 'array',
            'population_by_education' => 'array',
            'population_by_occupation' => 'array',
            'population_by_age_group' => 'array',
        ];
    }

    public function getIllustrationUrlAttribute(): ?string
    {
        return $this->illustration_path
            ? Storage::disk('uploads')->url($this->illustration_path)
            : null;
    }

    public function getPopulationDensityAttribute(): float
    {
        if ((float) $this->area_size <= 0) {
            return 0;
        }

        return round($this->total_population / (float) $this->area_size, 2);
    }

    public static function current(): self
    {
        return static::first() ?? static::create([
            'history_content' => '', 'founded_year' => now()->year,
            'vision' => '', 'area_size' => 0, 'altitude' => 0,
            'total_population' => 0, 'total_families' => 0,
            'map_center_lat' => 0, 'map_center_lng' => 0,
        ]);
    }
}
