<?php

namespace App\Repositories\Referensi;

use App\Models\Referensi;
use Illuminate\Support\Facades\DB;

class ReferensiRepository implements ReferensiRepositoryInterface
{
    public function getActive(): array
    {
        return DB::select("
        SELECT id, referensi, nilai, status
        FROM referensi
        WHERE status = 1
        ORDER BY id DESC
        ");
    }

    public function findById(int $id): ?array
    {
        $result = DB::selectOne("
            SELECT id, referensi, nilai, status
            FROM referensi
            WHERE id = ? AND status = 1
        ",  [$id]);
        
        return $result ? (array) $result : null;
    }

    public function store(array $data): int
    {
        DB::insert("
            INSERT INTO referensi (referensi, nilai, status
            VALUES (?, ?, ?)
        ", [
            $data['referensi'],
            $data['nilai'],
            1
        ]);
        
        return DB::getPdo()->lastInsertId();
    }

    public function update(int $id, array $data) : bool
    {
        return DB::update("
            UPDATE referensi
            SET referensi = ?, nilai = ?
            WHERE id = ? AND status = 1
        ", [
            $data['referensi'],
            $data['nilai'],
            $id
        ]) > 0;
    }

    public function softDelete(int $id): bool
    {
        return DB::update("
            UPDATE referensi
            SET status = 9
            WHERE id = ? AND status = 1
        ", [$id]) > 0;
    }
}