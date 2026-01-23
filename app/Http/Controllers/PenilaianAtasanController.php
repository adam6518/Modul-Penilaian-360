<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianAtasanController extends Controller
{
    // LOAD PAGE
    public function index()
    {
        return view('penilaian-atasan');
    }
}