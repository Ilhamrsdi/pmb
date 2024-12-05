<?php

namespace Database\Seeders;

use App\Models\GelombangPendaftaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GelombangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GelombangPendaftaran::create([
            'nama_gelombang' => 'Gelombang 1 - SMSB',
            'tahun_ajaran' => '2023/2024',
            'tanggal_mulai' => '2023-04-11',
            'tanggal_selesai' => '2023-05-20',
            'status' => 'Active',
            'deskripsi' => 'Jalur Mandiri',
            'nominal_pendaftaran' => '200000',
            'kuota_pendaftar' => 100
        ]);
        GelombangPendaftaran::create([
            'nama_gelombang' => 'Gelombang 2 - SMSB',
            'tahun_ajaran' => '2023/2024',
            'tanggal_mulai' => '2023-04-11',
            'tanggal_selesai' => '2023-05-20',
            'status' => 'Active',
            'deskripsi' => 'Jalur Mandiri',
            'nominal_pendaftaran' => '200000',
            'kuota_pendaftar' => 100
        ]);
        GelombangPendaftaran::create([
            'nama_gelombang' => 'Gelombang 1 - SMMP',
            'tahun_ajaran' => '2023/2024',
            'tanggal_mulai' => '2023-04-11',
            'tanggal_selesai' => '2023-05-20',
            'status' => 'Active',
            'deskripsi' => 'jalur Mandiri',
            'nominal_pendaftaran' => '200000',
            'kuota_pendaftar' => 100
        ]);
        GelombangPendaftaran::create([
            'nama_gelombang' => 'Gelombang 2 - SMMP',
            'tahun_ajaran' => '2023/2024',
            'tanggal_mulai' => '2023-04-11',
            'tanggal_selesai' => '2023-05-20',
            'status' => 'Active',
            'deskripsi' => 'Jalur Mandiri',
            'nominal_pendaftaran' => '200000',
            'kuota_pendaftar' => 100
        ]);
    }
}
