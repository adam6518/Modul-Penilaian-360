<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaian';

    protected $fillable = [
        'id_periode',
        'id_penilai',
        'id_ternilai',
        'ber',
        'a1',
        'k1',
        'h',
        'l',
        'a2',
        'k2'
    ];
    public $timestamps = false;
}