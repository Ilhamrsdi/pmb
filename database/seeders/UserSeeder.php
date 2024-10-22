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
            'nik' => '001',
            'username' => 'user 1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('user123'),
            'email_verified_at' => '2022-01-02 17:04:58',
            'avatar' => 'avatar-1.jpg'
        ]);

        User::create([
            'nik' => '002',
            'username' => 'user 2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('user123'),
            'email_verified_at' => '2022-01-02 17:04:58',
            'avatar' => 'avatar-1.jpg'
        ]);

        User::create([
            'nik' => '003',
            'username' => 'user 3',
            'email' => 'user3@gmail.com',
            'password' => Hash::make('user123'),
            'email_verified_at' => '2022-01-02 17:04:58',
            'avatar' => 'avatar-1.jpg',
            'role_id' => 2
        ]);

        User::create([
            'nik' => '000',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => '2022-01-02 17:04:58',
            'avatar' => 'avatar-1.jpg',
            'role_id' => 1
        ]);
    }
}
