<?php

namespace Database\Seeders;

use App\Models\DetailPendaftar;
use App\Models\Wali;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailPendaftarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DetailPendaftar::create([
            'pendaftar_id' => 1,
            'kode_bayar' => rand(100000, 999999),
            'va_pendaftaran' => 12345678
        ]);

        DetailPendaftar::create([
            'pendaftar_id' => 2,
            'kode_bayar' => rand(100000, 999999),
            'va_pendaftaran' => 12345678,
            'status_pendaftaran' => 'sudah'
        ]);

        DetailPendaftar::create([
            'pendaftar_id' => 3,
            'kode_bayar' => rand(100000, 999999),
            'va_pendaftaran' => 12345678,
            'va_ukt' => 87654321,
            'status_pendaftaran' => 'sudah',
            'nominal_ukt' => '10000'
        ]);
    }
}
