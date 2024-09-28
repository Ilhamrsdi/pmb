<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JurusanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Insert data into jurusans table
        $jurusan1Id = (string) Str::uuid();
        $jurusan2Id = (string) Str::uuid();
        DB::table('jurusans')->insert([
            [
                'id' => $jurusan1Id,
                'nama_jurusan' => 'Teknik Informatika',
                'alias_jurusan' => 'TI',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => $jurusan2Id,
                'nama_jurusan' => 'Teknik Mesin',
                'alias_jurusan' => 'TM',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

       
    }
}
