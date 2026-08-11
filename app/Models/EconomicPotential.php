<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EconomicPotential extends Model
{
    const SECTORS = [
        'makanan_minuman' => 'Makanan / Minuman',
        'warung_sembako' => 'Warung Sembako / Kelontong',
        'pertanian' => 'Pertanian / Hasil Kebun',
        'peternakan_perikanan' => 'Peternakan / Perikanan',
        'toko_bangunan' => 'Toko Bangunan / Material',
        'jasa_servis' => 'Jasa Servis / Keterampilan',
        'kerajinan_tangan' => 'Kerajinan Tangan / Kriya',
        'pakaian_fashion' => 'Pakaian / Fashion',
    ];

    protected $fillable = [
        'title', 'slug', 'description', 'content', 'sector', 'image_path', 'maps_url', 'order',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? Storage::disk('uploads')->url($this->image_path)
            : null;
    }

    public function getDetailContentAttribute(): string
    {
        return $this->content ?: $this->description;
    }

    public function getSectorLabelAttribute(): string
    {
        return self::SECTORS[$this->sector] ?? $this->sector;
    }
}
