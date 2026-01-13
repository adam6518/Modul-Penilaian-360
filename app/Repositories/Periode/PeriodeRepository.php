<?php

namespace App\Repositories\Periode;

use App\Models\Periode;
use Illuminate\Support\Facades\DB;

class PeriodeRepository implements PeriodeRepositoryInterface
{
    public function getActive(): array
    {
        return DB::select("
            SELECT id, nama_periode, tanggal_awal, tanggal_akhir, status
            FROM periode
            WHERE status = 1
            ORDER BY id DESC
        ");
    }

    public function findById(int $id): ?array
    {
        $result = DB::selectOne("
            SELECT id, nama_periode, tanggal_awal, tanggal_akhir, status
            FROM periode
            WHERE id = ? AND status = 1
        ", [$id]);

        return $result ? (array) $result : null;
    }

    public function store(array $data): int
    {
        DB::insert("
            INSERT INTO periode (nama_periode, tanggal_awal, tanggal_akhir, status)
            VALUES (?, ?, ?, ?)
        ", [
            $data['nama_periode'],
            $data['tanggal_awal'],
            $data['tanggal_akhir'],
            1
        ]);

        return DB::getPdo()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        return DB::update("
            UPDATE periode
            SET nama_periode = ?, tanggal_awal = ?, tanggal_akhir = ?
            WHERE id = ? AND status = 1
        ", [
            $data['nama_periode'],
            $data['tanggal_awal'],
            $data['tanggal_akhir'],
            $id
        ]) > 0;
    }

    public function softDelete(int $id): bool
    {
        return DB::update("
            UPDATE periode
            SET status = 9
            WHERE id = ? AND status = 1
        ", [$id]) > 0;
    }
}