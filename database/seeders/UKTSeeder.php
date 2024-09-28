<?php

namespace Database\Seeders;

use App\Models\Golongan;
use App\Models\Ukt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UKTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ukt::create([
            'golongan_id' => 1,
            'nominal_reguler' => 500000,
            'nominal_non_reguler' => 500000
        ]);
        Ukt::create([
            'golongan_id' => 2,
            'nominal_reguler' => 1000000,
            'nominal_non_reguler' => 1000000
        ]);
        Ukt::create([
            'golongan_id' => 3,
            'nominal_reguler' => 2400000,
            'nominal_non_reguler' => 2400000
        ]);
        Ukt::create([
            'golongan_id' => 4,
            'nominal_reguler' => 3000000,
            'nominal_non_reguler' => 3000000
        ]);
        Ukt::create([
            'golongan_id' => 5,
            'nominal_reguler' => 3500000,
            'nominal_non_reguler' => 3500000
        ]);
        Ukt::create([
            'golongan_id' => 6,
            'nominal_reguler' => 4000000,
            'nominal_non_reguler' => 4000000
        ]);
        Ukt::create([
            'golongan_id' => 7,
            'nominal_reguler' => 4500000,
            'nominal_non_reguler' => 4500000
        ]);
        Ukt::create([
            'golongan_id' => 8,
            'nominal_reguler' => 5000000,
            'nominal_non_reguler' => 5000000
        ]);
    }
}
