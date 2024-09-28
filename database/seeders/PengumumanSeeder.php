<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pengumuman::create([
            'judul_pengumuman' => 'Gelombang Pendaftaran Mandiri telah dibuka',
            'tanggal_pengumuman' => now(),
            'isi_pengumuman' => 'Gelombang pendaftaran mandiri telah dibuka. Silahkan mengikuti proses seleksi sehingga bisa masuk menjadi Mahasiswa Politeknik Negeri Banyuwangi. Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic dolorem quis veritatis facilis quia distinctio animi illum atque voluptates ullam impedit, veniam ducimus, fugiat illo! Nam fuga corporis sequi. Accusantium.'
        ]);

        Pengumuman::create([
            'judul_pengumuman' => 'Gelombang Pendaftaran Mandiri telah ditutup',
            'tanggal_pengumuman' => now(),
            'isi_pengumuman' => 'Gelombang pendaftaran mandiri telah ditutup. Selamat bagi yang lolos tahap seleksi dan sudah menjadi Mahasiswa Politeknik Negeri Banyuwangi. Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic dolorem quis veritatis facilis quia distinctio animi illum atque voluptates ullam impedit, veniam ducimus, fugiat illo! Nam fuga corporis sequi. Accusantium.'
        ]);
    }
}
