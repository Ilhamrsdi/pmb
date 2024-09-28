<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mahasiswa::create([
            'nama' => 'Mahasiswa 1',
            'status' => 'diterima',
        ]);

        Mahasiswa::create([
            'nama' => 'Mahasiswa 2',
            'status' => 'belum diterima',
        ]);

        // Tambahkan data mahasiswa lainnya sesuai kebutuhan
    }
}
