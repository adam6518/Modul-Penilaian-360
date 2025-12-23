<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PeriodePegawai;

class PeriodePegawaiController extends Controller
{
    public function index()
    {
        return view('periode-pegawai');
    }

    public function getData()
    {
        return response()->json(
            PeriodePegawai::where('status', '!=', 9)->get()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_periode'   => 'required|integer',
            'id_atasan'    => 'required|integer',
            'id_pegawai'   => 'required|integer',
            'nama_pegawai' => 'required|string',
            'nip'          => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['status'] = 1;

        $periodePegawai = PeriodePegawai::create($data);

        return response()->json($periodePegawai, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_periode'   => 'required|integer',
            'id_atasan'    => 'required|integer',
            'id_pegawai'   => 'required|integer',
            'nama_pegawai' => 'required|string',
            'nip'          => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $periodePegawai = PeriodePegawai::findOrFail($id);
        $periodePegawai->update($validator->validated());

        return response()->json($periodePegawai, 200);
    }

    public function delete($id)
    {
        $periodePegawai = PeriodePegawai::findOrFail($id);

        if ($periodePegawai->status != 1) {
            return response()->json([
                'message' => 'Data tidak bisa dihapus'
            ], 422);
        }

        $periodePegawai->update(['status' => 9]);

        return response()->json(['success' => true]);
    }
}