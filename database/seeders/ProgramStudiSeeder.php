<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $jurusan1Id = (string) Str::uuid();
        $jurusan2Id = (string) Str::uuid();
        DB::table('program_studis')->insert([
            [
                'id' => (string) Str::uuid(),
                'jurusan_id' => $jurusan1Id, // Ganti dengan ID jurusan yang valid jika ada
                'kode_program_studi' => 'TI1',
                'nama_program_studi' => 'Teknologi Rekayasa Perangkat Lunak',
                'jenjang_pendidikan' => 'D4',
                'akreditasi' => 'A',
                'kuota_diterima' => 100,
                'nomer_urut_nim' => 1,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'jurusan_id' => $jurusan2Id, // Ganti dengan ID jurusan yang valid jika ada
                'kode_program_studi' => 'TM1',
                'nama_program_studi' => 'Sarjana Terapan Teknik Rekayasa Manufaktur',
                'jenjang_pendidikan' => 'D4',
                'akreditasi' => 'B',
                'kuota_diterima' => 50,
                'nomer_urut_nim' => 1,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data dummy lainnya jika diperlukan
        ]);
    }
}
