<?php
namespace Database\Seeders;

use App\Models\Atribut;
use App\Models\DetailPendaftar; // Tambahkan ini untuk menambah status_pendaftaran
use App\Models\Pendaftar;
use App\Models\Wali;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendaftarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dapatkan UUID program studi dari tabel program_studis
        $programStudi1 = DB::table('program_studis')->where('kode_program_studi', '40')->first();
        $programStudi2 = DB::table('program_studis')->where('kode_program_studi', '50')->first();

        // Cek apakah program studi ditemukan sebelum melanjutkan
        if (!$programStudi1 || !$programStudi2) {
            // Jika salah satu program studi tidak ditemukan, hentikan seeding dan beri pesan
            $this->command->info('Program Studi tidak ditemukan. Pastikan tabel program_studis berisi data yang benar.');
            return;
        }

        // Tambahkan data ke tabel pendaftar
        $pendaftar1 = Pendaftar::create([
            'user_id' => 1,
            'gelombang_id' => 1,
            'program_studi_id' => $programStudi1->id,
            'nama' => 'Dimas'
        ]);

        $pendaftar2 = Pendaftar::create([
            'user_id' => 2,
            'gelombang_id' => 1,
            'program_studi_id' => $programStudi2->id,
            'nama' => 'Ilham'
        ]);

        // Pastikan UUID program studi ketiga benar dan ada
        $programStudi3Id = '1595d492-7643-470e-9a3e-cf2c4be4d38a';
        $programStudi3 = DB::table('program_studis')->where('id', $programStudi3Id)->first();

        if (!$programStudi3) {
            $this->command->info("Program Studi dengan UUID $programStudi3Id tidak ditemukan.");
            return;
        }

        $pendaftar3 = Pendaftar::create([
            'user_id' => 3,
            'gelombang_id' => 1,
            'program_studi_id' => $programStudi3Id,
            'nama' => 'Dandi'
        ]);

        // Tambahkan data ke tabel atribut dan wali untuk setiap pendaftar
        foreach ([$pendaftar1, $pendaftar2, $pendaftar3] as $pendaftar) {
            Atribut::create([
                'pendaftar_id' => $pendaftar->id
            ]);

            Wali::create([
                'pendaftar_id' => $pendaftar->id
            ]);

            // Tambahkan data status_pendaftaran di tabel detail_pendaftar
            DetailPendaftar::create([
                'pendaftar_id' => $pendaftar->id,
                'status_pendaftaran' => 'sudah', // Set nilai default 'belum' atau sesuai kebutuhan
                'status_pembayaran' => 'sudah',    // Nilai default bisa disesuaikan
                'va_pendaftaran' => '1234567890', // Contoh virtual account
                'datetime_expired' => now()->addDays(7), // Set waktu expired 7 hari dari sekarang
            ]);
        }
    }
}
