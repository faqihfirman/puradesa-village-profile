<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EconomicPotential extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'tags', 'image_path', 'order'];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? Storage::disk('uploads')->url($this->image_path)
            : null;
    }
}
