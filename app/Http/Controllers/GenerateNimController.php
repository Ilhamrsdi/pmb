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
                // Ambil data pendaftar berdasarkan ID
                $pendaftar = Pendaftar::with('programStudi')->find($id);
                // Lanjutkan ke pendaftar berikutnya jika data tidak ditemukan atau pendaftar tidak memiliki kode NIM
                if (!$pendaftar || !$pendaftar->programStudi || !$pendaftar->programStudi->kode_nim) {
                    continue;
                }
                
                // Ambil kode NIM berdasarkan program studi pendaftar
                $kode_nim = $pendaftar->programStudi->kode_nim;

                // Cari NIM terakhir yang sudah terdaftar untuk program studi ini
                $maba_nim = Pendaftar::whereHas('detailPendaftar', function ($query) {
                    $query->where('nim', '!=', null);
                })
                    ->whereHas('programStudi', function ($query) use ($kode_nim) {
                        $query->where('kode_nim', $kode_nim);
                    })
                    ->latest()
                    ->first();
                    // Mendapatkan nomor urut dari program studi
                    $nomer_urut = ProgramStudi::where('kode_nim', $kode_nim)->first();

                // Generate NIM berdasarkan data terakhir atau mulai dari nomor urut program studi
                if ($maba_nim == null || $maba_nim->nim == null) {
                    // Jika belum ada NIM, mulai dari nomor urut default program studi
                    $nim_mhs = $kode_kampus . substr($tahun_masuk, -2) . $kode_nim . $nomer_urut->nomer_urut_nim;
                } else {
                    // Jika ada NIM, tambahkan 1 dari NIM terakhir
                    $nim_mhs = $maba_nim->nim + 1;
                }

                // Update NIM untuk pendaftar saat ini
              $pendaftar->update(['nim' => $nim_mhs]) ;
                
            }
        }

        // Kembali ke halaman sebelumnya setelah proses selesai
        return redirect()->back();
    }
}