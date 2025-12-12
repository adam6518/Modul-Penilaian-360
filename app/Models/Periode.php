<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periode'; // Nama tabel di database

    protected $fillable = [
        'nama_periode',
        'tanggal_awal',
        'tanggal_akhir'
    ];

    public $timestamps = false; // Karena tabel database tidak punya created_at & updated_at
}
