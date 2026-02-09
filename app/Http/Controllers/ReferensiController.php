<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Referensi;

class ReferensiController extends Controller
{
    public function index()
    {
        return view('referensi');
    }

    public function getData()
    {
        return response()->json(
            DB::select("
                SELECT id, referensi, kode, jenis, nilai, status
                FROM referensi
                WHERE status != 9
                ORDER BY kode ASC
            ")
        );
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'referensi' => 'required|string',
            'kode' => 'required|in:atasan,sejawat,bawahan,col_01,col_02,col_03,col_04,col_05,col_06,col_07',
            'jenis' => 'required|string',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        DB::insert("
            INSERT INTO referensi (referensi, kode, nilai, status)
            VALUES (?, ?, ?, 1)
        ", [
            $data['referensi'],
            $data['kode'],
            $data['jenis'],
            $data['nilai']
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'referensi' => 'required|string',
            'kode' => 'required|in:col_01,col_02,col_03,col_04,col_05,col_06,col_07',
            'jenis' => 'required|string',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        DB::update("
            UPDATE referensi
            SET referensi = ?, kode = ?, nilai = ?
            WHERE id = ? AND status = 1
        ", [
            $data['referensi'],
            $data['kode'],
            $data['jenis'],
            $data['nilai'],
            $id
        ]);

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        DB::update("
            UPDATE referensi
            SET status = 9
            WHERE id = ? AND status = 1
        ", [$id]);

        return response()->json(['success' => true]);
    }
}