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
        return response()->json(Periode::all());
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

        $periode = Periode::create($validator->validated());

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
        $periode->delete();

        return response()->json(['success' => true]);
    }
}