<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodePegawai extends Model
{
    protected $table = 'periode_pegawai';

    protected $fillable = [
        'id_periode',
        'id_atasan',
        'nama_pegawai',
        'nip',
        'id_pegawai',
        'id_satker',
        'status'
    ];
    public $timestamps = false;
}