<?php

namespace App\Imports;

use App\Models\Atribut;
use App\Models\DetailPendaftar;
use App\Models\Pendaftar;
use App\Models\User;
use App\Models\Wali;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class PendaftarImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // dd($collection);
        foreach ($collection as $key => $row) {
            if ($key >= 1) {
                $password = rand(100000, 999999);
                $user = User::create([
                    'username' => $row[0],
                    'nik' => $row[2],
                    'email' => $row[1],
                    'avatar' => 'avatar-1.jpg',
                    'role_id' => 2,
                    'password' => Hash::make($password),
                ]);
                $pendaftar = Pendaftar::create([
                    'user_id' => $user->id,
                    'gelombang_id' => 2,
                    'program_studi_id' => 2,
                    'nama' => $row[3],
                    'sekolah' => $row[4],
                ]);
                DetailPendaftar::create([
                    'pendaftar_id' => $pendaftar->id,
                    'kode_bayar' => $password,
                    'status_pendaftaran' => 'sudah',
                ]);
                Wali::create([
                    'pendaftar_id' => $pendaftar->id,
                ]);
                Atribut::create([
                    'pendaftar_id' => $pendaftar->id,
                ]);
            }
        }
    }
}
