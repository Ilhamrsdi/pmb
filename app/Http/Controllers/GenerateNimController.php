<?php

namespace App\Http\Controllers;

use App\Models\DetailPendaftar;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\ProgramStudi;


class GenerateNimController extends Controller
{
    // Menampilkan daftar pendaftar yang belum memiliki NIM
    public function index()
    {
        // Mengambil semua pendaftar yang belum memiliki NIM dan memiliki status_ukt serta status_acc 'sudah' dari relasi detailPendaftar
        $maba_ukt = Pendaftar::with('programStudi', 'detailPendaftar')
            ->whereNull('nim') // Hanya ambil pendaftar yang belum punya NIM
            ->whereHas('detailPendaftar', function ($query) {
                $query->where('status_ukt', 'sudah') // Hanya pendaftar dengan status_ukt 'sudah'
                    ->where('status_acc', 'sudah'); // Hanya pendaftar dengan status_acc 'sudah'
            })
            ->get();

        // Kirim data ke view
        return view('generate-nim.index', compact('maba_ukt'));
    }


    // Melakukan generate NIM secara massal

// public function generateNIMMassal(Request $request)
// {
//     $maba_nim = Pendaftar::whereHas('detailPendaftar', function ($query) {
//         $query->where('nim', '!=', null);
//     })

//         ->whereHas('programStudi', function ($query) use ($request) {
//             $query->where('kode_nim', $request->kode_nim);
//         })->latest()->first();
//         // dd($maba_nim->nim);
//         $nomer_urut = ProgramStudi::where('kode_nim', $request->kode_nim)->first();
//         $tahun_masuk = date('Y');
//         // dd($nomer_urut);
//         $kode_kampus = 36;
//         if ($maba_nim == null || $maba_nim->nim == null) {
//             $nim_mhs = $kode_kampus . substr($tahun_masuk, -2) . $request->kode_nim . $nomer_urut->nomer_urut_nim;
//         } else {
//             $nim_mhs = $maba_nim->nim + 1;
//         }
//     //    dd($nim_mhs);
//        Pendaftar::where('id', $request->id_pendaftar)->update(['nim' => $nim_mhs]);
//        return redirect()->back();
// }
public function generateNIMMassal(Request $request)
{
    // Mendapatkan tahun masuk dengan format empat angka, misalnya "2024"
    $tahun_masuk = date('Y');

    // Kode kampus tetap diatur ke 36
    $kode_kampus = 36;

    // Pastikan 'id_pendaftar' adalah array
    if (is_array($request->id_pendaftar)) {
        foreach ($request->id_pendaftar as $id) {
            // Ambil data pendaftar beserta program studi
            $pendaftar = Pendaftar::with('programStudi')->find($id);

            // Lanjutkan ke pendaftar berikutnya jika data tidak ditemukan
            if (!$pendaftar || !$pendaftar->programStudi) {
                continue;
            }

            // Ambil kode dari kolom 'code' di tabel Program Studi
            $kode_nim = $pendaftar->programStudi->code;

            // Ambil angka belakang dari kode_nim (misal 21401 -> ambil "401")
            $kode_belakang_prodi = substr($kode_nim, -3);

            // Ambil nomor urut terakhir berdasarkan program studi (kode_nim)
            $maba_nim = Pendaftar::whereHas('programStudi', function ($query) use ($kode_nim) {
                $query->where('code', $kode_nim);
            })->latest()->first();

            // Tentukan nomor urut baru
            $nomor_urut_baru = 1; // Default nomor urut awal jika belum ada data
            if ($maba_nim && $maba_nim->nim) {
                // Ambil 4 digit terakhir dari NIM sebelumnya dan tambahkan 1
                $nomor_urut_baru = (int) substr($maba_nim->nim, -4) + 1;
            }

            // Generate NIM
            $nim_mhs = $kode_kampus
                . substr($tahun_masuk, -2)
                . $kode_belakang_prodi
                . str_pad($nomor_urut_baru, 4, '0', STR_PAD_LEFT);

            // Update NIM ke database
            $pendaftar->update(['nim' => $nim_mhs]);
            $pendaftar->detailPendaftar->update(['status_mahasiswa' => 'aktif']);
        }
    }

    return back()->with('success', 'NIM berhasil di-generate secara massal!');
}

}