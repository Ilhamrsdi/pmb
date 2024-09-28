<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            ['name' => 'Indonesia', 'code' => 'ID', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'United States', 'code' => 'US', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'United Kingdom', 'code' => 'UK', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Australia', 'code' => 'AU', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Canada', 'code' => 'CA', 'created_at' => now(), 'updated_at' => now()],
            // Tambahkan negara lain sesuai kebutuhan
        ]);
        //
    }
}
