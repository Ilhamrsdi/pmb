<?php

namespace Database\Seeders;

use App\Models\Golongan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Golongan::create([
            'nama_golongan' => 'KELOMPOK 1',
            'kriteria' => 'MAHASISWA BEASISWA / PENGHASILAN ORANG TUA < Rp. 500.000'
        ]);
        Golongan::create([
            'nama_golongan' => 'KELOMPOK 2',
            'kriteria' => 'PENGHASILAN ORANG TUA < Rp. 1.000.000'
        ]);
        Golongan::create([
            'nama_golongan' => 'KELOMPOK 3',
            'kriteria' => 'PENGHASILAN ORANG TUA < Rp. 1.500.000'
        ]);
        Golongan::create([
            'nama_golongan' => 'KELOMPOK 4',
            'kriteria' => 'PENGHASILAN ORANG TUA < Rp. 2.500.000'
        ]);
        Golongan::create([
            'nama_golongan' => 'KELOMPOK 5',
            'kriteria' => 'PENGHASILAN ORANG TUA < Rp. 3.000.000'
        ]);
        Golongan::create([
            'nama_golongan' => 'KELOMPOK 6',
            'kriteria' => 'PENGHASILAN ORANG TUA < Rp. 3.500.000'
        ]);
        Golongan::create([
            'nama_golongan' => 'KELOMPOK 7',
            'kriteria' => 'PENGHASILAN ORANG TUA < Rp. 4.500.000'
        ]);
        Golongan::create([
            'nama_golongan' => 'KELOMPOK 7',
            'kriteria' => 'PENGHASILAN ORANG TUA > Rp. 5.000.000'
        ]);
    }
}
