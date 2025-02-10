<?php

namespace Database\Seeders;

use App\Models\TanggalPenting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TanggalPentingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TanggalPenting::insert([
            ['nama_kegiatan' => 'Pembukaan Pendaftaran', 'tanggal_mulai' => '2025-01-01', 'tanggal_selesai' => '2025-03-31'],
            ['nama_kegiatan' => 'Seleksi Administrasi', 'tanggal_mulai' => '2025-04-01', 'tanggal_selesai' => '2025-04-15'],
            ['nama_kegiatan' => 'Ujian Tulis', 'tanggal_mulai' => '2025-04-20', 'tanggal_selesai' => '2025-04-21'],
            ['nama_kegiatan' => 'Pengumuman Hasil', 'tanggal_mulai' => '2025-04-30', 'tanggal_selesai' => null],
        ]);
    }
}
