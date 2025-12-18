<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referensi extends Model
{
    protected $table = 'referensi';

    protected $fillable = [
        'referensi',
        'nilai',
        'status'
    ];

    protected $casts = [
        'nilai' => 'float'
    ];

    public $timestamps = false;
}