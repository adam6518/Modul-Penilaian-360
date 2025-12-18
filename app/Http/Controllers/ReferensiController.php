<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            Referensi::where('status', '!=', 9)->get()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referensi' => 'required|string',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['status'] = 1;

        $referensi = Referensi::create($data);

        return response()->json($referensi, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'referensi' => 'required|string',
            'nilai' => 'required|numeric|min:0|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $referensi = Referensi::findOrFail($id);
        $referensi->update($validator->validated());

        return response()->json($referensi, 200);
    }

    public function delete($id)
    {
        $referensi = Referensi::findOrFail($id);
        if ($referensi->status != 1) {
            return response()->json([
                'message' => 'Referensi tidak bisa dihapus'
            ], 422);
        }
        $referensi->update(['status' => 9]);

        return response()->json(['success' => true]);
    }
}