<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageEvent extends Model
{
    protected $fillable = ['name', 'date', 'start_time', 'end_time', 'location', 'description'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
