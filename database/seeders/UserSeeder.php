<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'nik' => '000',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => '2022-01-02 17:04:58',
            'avatar' => 'avatar-1.jpg',
            'role_id' => 1
        ]);
        User::create([
            'nik' => '123',
            'username' => 'panitia',
            'email' => 'panitia@gmail.com',
            'password' => Hash::make('panitia123'),
            'email_verified_at' =>  '2022-01-02 17:04:58',
            'avatar' => 'avatar-2.jpg',
            'role_id' => 3
        ]);
    }
}
