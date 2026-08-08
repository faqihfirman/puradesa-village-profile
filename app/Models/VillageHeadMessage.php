<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VillageHeadMessage extends Model
{
    protected $fillable = ['name', 'position', 'photo_path', 'message'];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path
            ? Storage::disk('uploads')->url($this->photo_path)
            : null;
    }

    public static function current(): self
    {
        return static::first() ?? static::create([
            'name' => '', 'position' => 'Kepala Desa', 'message' => '',
        ]);
    }
}
