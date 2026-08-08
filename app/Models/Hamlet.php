<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hamlet extends Model
{
    protected $fillable = ['name', 'population', 'families', 'order'];
}
