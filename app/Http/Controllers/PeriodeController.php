<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Periode;
use App\UseCases\Periode\{
    GetPeriodeUseCase,
    CreatePeriodeUseCase,
    UpdatePeriodeUseCase,
    DeletePeriodeUseCase
};

class PeriodeController extends Controller
{
    // Load data first time
    public function index(GetPeriodeUseCase $useCase)
    {
        return view('periode', [
            'periode' => $useCase->execute()
        ]);
    }

    // Ambil semua data (AJAX)
    public function getData(GetPeriodeUseCase $useCase)
    {
        return response()->json($useCase->execute());
    }

    // public function getData()
    // {
    //     return response()->json(
    //         Periode::where('status', '!=', 9)->get()
    //     );
    // }

    // Create Periode

    public function store(
        Request $request,
        CreatePeriodeUseCase $useCase
    ) {
        $id = $useCase->execute($request->all());

        return response()->json(['id' => $id], 201);
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'nama_periode' => 'required',
    //         'tanggal_awal' => 'required|date',
    //         'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     // $periode = Periode::create($validator->validated());
    //     $data = $validator->validated();
    //     $data['status'] = 1;

    //     $periode = Periode::create($data);


    //     return response()->json($periode, 201);
    // }

    // Update Periode
    public function update(Request $request, int $id, UpdatePeriodeUseCase $useCase)
    {
        $useCase->execute($id, $request->all());

        return response()->json(['success' => true]);
    }

    // Delete Periode
    public function delete(int $id, DeletePeriodeUseCase $useCase)
    {
        $useCase->execute($id);

        return response()->json(['success' => true]);
    }

    // public function delete($id)
    // {
    //     $periode = Periode::findOrFail($id);
    //     if ($periode->status == 0) {
    //         return response()->json([
    //             'message' => 'Periode sudah selesai dan tidak bisa dihapus'
    //         ], 422);
    //     }
    //     $periode->update(['status' => 9]);

    //     return response()->json(['success' => true]);
    // }

    // Get List Nama Periode untuk di Halaman Periode Pegawai

    // public function getList(
    //     PeriodeRepositoryInterface $repo
    // ) {
    //     return response()->json($repo->getList());
    // }

    // public function getList()
    // {
    //     return response()->json(
    //         Periode::where('status', '!=', 9)
    //             ->select('id', 'nama_periode')
    //             ->get()
    //     );
    // }
}