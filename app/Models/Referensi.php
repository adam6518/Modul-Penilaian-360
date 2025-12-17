<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Referensi extends Model
{
    // use SoftDeletes;

    protected $table = 'referensi';

    protected $fillable = [
        'referensi',
        'nilai'
    ];

    // protected $dates = ['deleted_at'];

    public $timestamps = false;
}