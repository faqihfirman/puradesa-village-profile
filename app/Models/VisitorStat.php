<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorStat extends Model
{
    public $timestamps = false;

    protected $fillable = ['date', 'visits', 'unique_visitors'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
