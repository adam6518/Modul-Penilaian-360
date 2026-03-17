<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeriodeController extends Controller
{
    // Load data first time
    public function index()
    {
        return view('periode');
    }

    // Ambil semua data (AJAX)
    public function getData()
    {
        try {
            return response()->json(
            DB::select("
                SELECT id, nama_periode, tanggal_awal, tanggal_akhir, status
                FROM periode
                WHERE status != 9
                ORDER BY id DESC
            ")
        );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            
            return response()->json([
                'success'=>false,
                'message'=>"Gagal Menampilkan Periode"
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_periode' => 'required|string',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

       try {
         DB::insert("
            INSERT INTO periode (nama_periode, tanggal_awal, tanggal_akhir, status)
            VALUES (?, ?, ?, 1)
        ", [
            $data['nama_periode'],
            $data['tanggal_awal'],
            $data['tanggal_akhir'],
        ]);

        return response()->json(['success' => true]);
       } catch (\Exception $e) {
            Log::error($e->getMessage());
            
            return response()->json([
                'success'=>false,
                'message'=>"Gagal Menambahkan Periode"
            ], 500);
        }
    }
    // Update Periode
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_periode' => 'required|string',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

       try {
         DB::update("
            UPDATE periode
            SET nama_periode = ?, tanggal_awal = ?, tanggal_akhir = ?
            WHERE id = ? AND status != 9
        ", [
            $data['nama_periode'],
            $data['tanggal_awal'],
            $data['tanggal_akhir'],
            $id
        ]);

        return response()->json(['success' => true]);
       } catch (\Exception $e) {
            Log::error($e->getMessage());
            
            return response()->json([
                'success'=>false,
                'message'=>"Gagal Update Periode"
            ], 500);
        }
    }

    // Delete Periode
    public function delete($id)
    {
        try {
            DB::update("
            UPDATE periode
            SET status = 9
            WHERE id = ? AND status != 9
        ", [$id]);

        return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            
            return response()->json([
                'success'=>false,
                'message'=>"Gagal Menghapus Periode"
            ], 500);
        }
    }
}