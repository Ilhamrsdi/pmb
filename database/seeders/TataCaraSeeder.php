<?php

namespace Database\Seeders;

use App\Models\TataCara;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TataCaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tata Cara Pendaftaran
        TataCara::create([
            'title' => 'Langkah Pertama',
            'deskripsi' => 'Bagi calon mahasiswa baru (CAMABA) yang akan mendaftar, harus melakukan pendaftaran akun terlebih dahulu pada form pendaftaran dan mendapatkan kode pembayaran pendaftaran.',
            'jenis' => 'pendaftaran'
        ]);

        TataCara::create([
            'title' => 'Langkah Kedua',
            'deskripsi' => 'Melakukan pembayaran menggunakan kode bayar pendaftaran ke bank yang sudah dipilih dan virtual account yang sudah didapat.',
            'jenis' => 'pendaftaran'
        ]);

        TataCara::create([
            'title' => 'Langkah Ketiga',
            'deskripsi' => 'Jika sudah melakukan pembayaran loginlah ke website dengan kode bayar dan nik yang sudah diisikan sebelumnya kemudian mengisi dan melengkapi form pendaftaran.',
            'jenis' => 'pendaftaran'
        ]);

        TataCara::create([
            'title' => 'Langkah Keempat',
            'deskripsi' => 'Mengikuti dan mengisi beberapa test di menu test maba, dan mengisinya dengan sebaik baiknya dalam jangka waktu yang sudah ditetapkan.',
            'jenis' => 'pendaftaran'
        ]);

        TataCara::create([
            'title' => 'Langkah Kelima',
            'deskripsi' => 'Menunggu hasil informasi penerimaan oleh panitia PMB.',
            'jenis' => 'pendaftaran'
        ]);

        TataCara::create([
            'title' => 'Langkah Keenam',
            'deskripsi' => 'Jika Nilai yang didapat memenuhi standar maka tunggu sampai mendapatkan nominal UKT.',
            'jenis' => 'pendaftaran'
        ]);

        TataCara::create([
            'title' => 'Langkah Ketujuh',
            'deskripsi' => 'Melakukan pembayaran UKT ke BANK menggunakan nomor VA yang telah didapatkan.',
            'jenis' => 'pendaftaran'
        ]);

        TataCara::create([
            'title' => 'Langkah Kedelapan',
            'deskripsi' => 'Login kembali kedalam website dan cetak bukti pembayaran dan mendapatkan NIM Mahasiswa Baru.',
            'jenis' => 'pendaftaran'
        ]);

        // Tata Cara Pembayaran via ATM BNI
        TataCara::create([
            'title' => 'Langkah Pertama',
            'deskripsi' => 'Masukkan Kartu kedalam mesin ATM. Pilih Bahasa kemudian masukkan PIN ATM Anda. Kemudian, pilih Menu Lainnya.',
            'jenis' => 'pembayaran atm'
        ]);

        TataCara::create([
            'title' => 'Langkah Kedua',
            'deskripsi' => 'Pilih "Menu Lainnya", lalu Pilih "Transfer".',
            'jenis' => 'pembayaran atm'
        ]);

        TataCara::create([
            'title' => 'Langkah Ketiga',
            'deskripsi' => 'Pilih jenis rekening yang anda akan anda gunakan (Contoh: "Dari Rekening Tabungan").',
            'jenis' => 'pembayaran atm'
        ]);

        TataCara::create([
            'title' => 'Langkah Keempat',
            'deskripsi' => 'Pilih "Virtual Account Billing" dan masukkan nomor Virtual Account Anda.',
            'jenis' => 'pembayaran atm'
        ]);

        TataCara::create([
            'title' => 'Langkah Kelima',
            'deskripsi' => 'Tagihan yang harus dibayarkan akan muncul pada layar konfirmasi. Pilih Konfirmasi, apabila telah sesuai, dan lanjutkan transaksi.',
            'jenis' => 'pembayaran atm'
        ]);

        TataCara::create([
            'title' => 'Langkah Keenam',
            'deskripsi' => 'Transaksi Anda telah selesai.',
            'jenis' => 'pembayaran atm'
        ]);

        // Tata Cara Pembayaran via Mobile Banking BNI
        TataCara::create([
            'title' => 'Langkah Pertama',
            'deskripsi' => 'Akses BNI Mobile Banking dari handphone, kemudian masukkan user ID dan password.',
            'jenis' => 'pembayaran m-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Kedua',
            'deskripsi' => 'Pilih menu "Transfer", lalu pilih menu "Virtual Account Billing".',
            'jenis' => 'pembayaran m-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Ketiga',
            'deskripsi' => 'Pilih rekening debet dan masukan nomor Virtual Account Anda pada menu "input baru".',
            'jenis' => 'pembayaran m-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Keempat',
            'deskripsi' => 'Tagihan yang harus dibayarkan akan muncul pada layar konfirmasi. Kemudian, Konfirmasi transaksi dengan masukan Password Transaksi.',
            'jenis' => 'pembayaran m-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Kelima',
            'deskripsi' => 'Pembayaran berhasil dilakukan.',
            'jenis' => 'pembayaran m-banking'
        ]);

        // Tata Cara Pembayaran via Internet Banking BNI
        TataCara::create([
            'title' => 'Langkah Pertama',
            'deskripsi' => 'Ketik alamat https://ibank.bni.co.id kemudian klik "Enter". Kemudian, masukan User ID dan Password.',
            'jenis' => 'pembayaran i-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Kedua',
            'deskripsi' => 'Pilih menu "Transfer", lalu pilih menu "Virtual Account Billing".',
            'jenis' => 'pembayaran i-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Ketiga',
            'deskripsi' => 'Kemudian masukan nomor Virtual Account Anda yang hendak dibayarkan. Lalu pilih rekening debet yang akan digunakan. Kemudian tekan "lanjut".',
            'jenis' => 'pembayaran i-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Keempat',
            'deskripsi' => 'Kemudian tagihan yang harus dibayarkan akan muncul pada layar konfirmasi.',
            'jenis' => 'pembayaran i-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Kelima',
            'deskripsi' => 'Masukan Kode Otentikasi Token.',
            'jenis' => 'pembayaran i-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Keenam',
            'deskripsi' => 'Pembayaran berhasil dilakukan.',
            'jenis' => 'pembayaran i-banking'
        ]);

        // Tata Cara Pembayaran via SMS Banking BNI
        TataCara::create([
            'title' => 'Langkah Pertama',
            'deskripsi' => 'Buka aplikasi SMS Banking BNI.',
            'jenis' => 'pembayaran sms-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Kedua',
            'deskripsi' => 'Pilih menu "Transfer".',
            'jenis' => 'pembayaran sms-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Ketiga',
            'deskripsi' => 'Pilih Menu Transfer rekening BNI.',
            'jenis' => 'pembayaran sms-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Keempat',
            'deskripsi' => 'Masukan nomor rekening tujuan dengan 16 digit Nomor Virtual Account.',
            'jenis' => 'pembayaran sms-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Kelima',
            'deskripsi' => 'Masukan nominal transfer sesuai tagihan atau kewajiban Anda. Nominal yang berbeda tidak dapat diproses.',
            'jenis' => 'pembayaran sms-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Keenam',
            'deskripsi' => 'Pilih "Proses" kemudian "Setuju".',
            'jenis' => 'pembayaran sms-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Ketujuh',
            'deskripsi' => 'Reply sms dengan ketik pin sesuai perintah.',
            'jenis' => 'pembayaran sms-banking'
        ]);

        TataCara::create([
            'title' => 'Langkah Kedelapan',
            'deskripsi' => 'Transaksi Berhasil.',
            'jenis' => 'pembayaran sms-banking'
        ]);

        // Tata Cara Pembayaran via Outlet BNI (Teller)
        TataCara::create([
            'title' => 'Langkah Pertama',
            'deskripsi' => 'Kunjungi Kantor Cabang/outlet BNI terdekat.',
            'jenis' => 'pembayaran teller'
        ]);

        TataCara::create([
            'title' => 'Langkah Kedua',
            'deskripsi' => 'Informasikan kepada Teller, bahwa ingin melakukan pembayaran "Virtual Account Billing".',
            'jenis' => 'pembayaran teller'
        ]);

        TataCara::create([
            'title' => 'Langkah Ketiga',
            'deskripsi' => 'Serahkan nomor Virtual Account Anda kepada Teller.',
            'jenis' => 'pembayaran teller'
        ]);

        TataCara::create([
            'title' => 'Langkah Keempat',
            'deskripsi' => 'Teller melakukan konfirmasi nominal pembayaran kepada Anda.',
            'jenis' => 'pembayaran teller'
        ]);

        TataCara::create([
            'title' => 'Langkah Kelima',
            'deskripsi' => 'Teller memproses Transaksi.',
            'jenis' => 'pembayaran teller'
        ]);

        TataCara::create([
            'title' => 'Langkah Keenam',
            'deskripsi' => 'Apabila transaksi Sukses Anda akan menerima bukti pembayaran dari Teller tersebut.',
            'jenis' => 'pembayaran teller'
        ]);

        // Tata Cara Pembayaran via Agen46 BNI
        TataCara::create([
            'title' => 'Langkah Pertama',
            'deskripsi' => 'Kunjungi Agen46 terdekat (warung/toko/kios dengan tulisan Agen46).',
            'jenis' => 'pembayaran agen'
        ]);

        TataCara::create([
            'title' => 'Langkah Kedua',
            'deskripsi' => 'Informasikan kepada Agen46, bahwa ingin melakukan pembayaran "Virtual".',
            'jenis' => 'pembayaran agen'
        ]);

        TataCara::create([
            'title' => 'Langkah Ketiga',
            'deskripsi' => 'Serahkan nomor Virtual Account Anda kepada Agen46.',
            'jenis' => 'pembayaran agen'
        ]);

        TataCara::create([
            'title' => 'Langkah Keempat',
            'deskripsi' => 'Agen46 melakukan konfirmasi nominal pembayaran kepada Anda.',
            'jenis' => 'pembayaran agen'
        ]);

        TataCara::create([
            'title' => 'Langkah Kelima',
            'deskripsi' => 'Agen46 memproses Transaksi.',
            'jenis' => 'pembayaran agen'
        ]);

        TataCara::create([
            'title' => 'Langkah Keenam',
            'deskripsi' => 'Apabila transaksi Sukses Anda akan menerima bukti pembayaran dari Agen56 tersebut.',
            'jenis' => 'pembayaran agen'
        ]);
    }
}
