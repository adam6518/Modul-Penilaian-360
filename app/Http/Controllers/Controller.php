<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\View;

class Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected array $userPenilai;
    public function __construct()
    {
        $this->userPenilai = [
            'id'   => 12,
            'nama' => 'Atasan 1'
        ];

        View::share('userPenilai', $this->userPenilai);
    }
}