<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Periode;

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
        return response()->json(
            Periode::where('status', '!=', 9)->get()
        );
    }

    // Create Periode
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_periode' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $periode = Periode::create($validator->validated());
        $data = $validator->validated();
        $data['status'] = 1;

        $periode = Periode::create($data);


        return response()->json($periode, 201);
    }

    // Update Periode
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_periode' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $periode = Periode::findOrFail($id);
        $periode->update($validator->validated());

        return response()->json($periode);
    }

    // Delete Periode
    public function delete($id)
    {
        $periode = Periode::findOrFail($id);
        if ($periode->status == 0) {
            return response()->json([
                'message' => 'Periode sudah selesai dan tidak bisa dihapus'
            ], 422);
        }
        $periode->update(['status' => 9]);

        return response()->json(['success' => true]);
    }

    // Get List Nama Periode untuk di Halaman Periode Pegawai
    public function getList()
    {
        return response()->json(
            Periode::where('status', '!=', 9)
                ->select('id', 'nama_periode')
                ->get()
        );
    }
}