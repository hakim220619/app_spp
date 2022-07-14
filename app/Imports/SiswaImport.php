<?php

namespace App\Imports;

use App\Models\Master\Kelas;
use App\Models\Master\Siswa;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    /**
     * @inheritDoc
     */
    public function collection(Collection $collection)
    {
        $allClass = Kelas::all()->toArray();
        DB::beginTransaction();
        foreach ($collection as $row) {
            $idx = $this->searchForClassName($row['kelas'], $allClass);
            $classId = 0;
            $unitId = 0;
            if ($idx >= -1) {
                $classId = $allClass[$idx]['id'];
                $unitId = $allClass[$idx]['unit_id'];
            }
            Siswa::create([
                'nis' => $row['nis'],
                'name' => $row['nama'],
                'email' => $row['email'],
                'gender' => $row['gender'],
                'phone' => $row['nomor_wa'],
                'date_of_birth' => date('Y-m-d', strtotime($row['tanggal_lahir'])),
                'status' => 'Aktif',
                'class_id' => $classId,
                'unit_id' => $unitId,
                'description' => null,
                'year' => date('Y')
            ]);

            User::create([
                'email' => $row['email'],
                'password' => Hash::make($row['nis']),
                'role_id' => 3
            ]);
        }
        DB::commit();
    }

    private function searchForClassName($className, $array)
    {
        foreach ($array as $key => $val) {
            if (strtolower($val['name']) === strtolower($className)) {
                return $key;
            }
        }
        return null;
    }
}
