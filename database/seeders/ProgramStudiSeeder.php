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
                'id' => 'c5de86f9-c6b4-4740-961b-32da3b1c003a',
                'jurusan_id' => $jurusan1Id, // Ganti dengan ID jurusan yang valid jika ada
                'kode_program_studi' => '41311',
                'nama_program_studi' => 'Agribisnis',
                'jenjang_pendidikan' => 'D4',
                'akreditasi' => 'A',
                'kuota_diterima' => 100,
                'nomer_urut_nim' => 1,
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => '7831ea95-1f70-4335-93c8-a81f14745b2c',
                'jurusan_id' => $jurusan2Id, // Ganti dengan ID jurusan yang valid jika ada
                'kode_program_studi' => '55401',
                'nama_program_studi' => 'Teknik Informatika',
                'jenjang_pendidikan' => 'D3',
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
