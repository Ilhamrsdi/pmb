<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PendaftarSeeder::class,
            DetailPendaftarSeeder::class,
            ProdiSeeder::class,
            JurusanSeeder::class,
            GolonganSeeder::class,
            GelombangSeeder::class,
            UKTSeeder::class,
            TataCaraSeeder::class,
            PengumumanSeeder::class,
        ]);
    }
}
