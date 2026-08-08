<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Official extends Model
{
    const LEVEL_LABELS = [
        1 => 'Kepala Desa',
        2 => 'Sekretaris Desa',
        3 => 'Kaur/Kasi',
        4 => 'Kepala Dusun',
    ];

    protected $fillable = [
        'name', 'position', 'level', 'photo_path', 'phone', 'email',
        'period_start', 'period_end', 'is_active', 'order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path
            ? Storage::disk('uploads')->url($this->photo_path)
            : null;
    }

    public function getLevelLabelAttribute(): string
    {
        return self::LEVEL_LABELS[$this->level] ?? '—';
    }
}
