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
    


    
    
// public function generateNIMMassal(Request $request)
// {
//     // Debugging untuk melihat data request
//     // dd($request->all());

//     // Ambil pendaftar yang sudah memiliki NIM
//     $maba_nim = Pendaftar::where('nim', '!=', null)
//         ->whereHas('programStudi', function ($query) use ($request) {
//             $query->where('kode_nim', $request->kode_nim);
//         })
//         ->orderBy('nim', 'desc')
//         ->first();

//     // Debugging untuk memeriksa hasil maba_nim
//     // dd($maba_nim);

//     // Ambil nomor urut dari program studi
//     $nomer_urut = ProgramStudi::where('kode_nim', $request->kode_nim)->first();

//     // Debugging untuk memeriksa apakah nomer_urut ditemukan
//     // dd($nomer_urut);

//     // Cek apakah nomer_urut valid
//     if ($nomer_urut == null) {
//         return redirect()->back()->with('error', 'Nomor urut tidak ditemukan untuk kode_nim: ' . $request->kode_nim);
//     }

//     // Tentukan tahun masuk dan kode kampus
//     $tahun_masuk = date('Y');
//     $kode_kampus = 36;

//     // Proses untuk setiap pendaftar yang dipilih
//     foreach ($request->id_pendaftar as $id) {
//         // Ambil pendaftar berdasarkan ID
//         $pendaftar = Pendaftar::find($id);

//         // Debugging untuk memeriksa apakah pendaftar ditemukan
//         if ($pendaftar == null) {
//             return redirect()->back()->with('error', 'Pendaftar tidak ditemukan dengan ID: ' . $id);
//         }

//         // Tentukan NIM baru
//         if ($maba_nim == null || $maba_nim->nim == null) {
//             // Gunakan nomor urut dari program studi
//             $nim_mhs = $kode_kampus . substr($tahun_masuk, -2) . $request->kode_nim . str_pad($nomer_urut->nomer_urut_nim, 4, '0', STR_PAD_LEFT);
//         } else {
//             // Tambahkan 1 ke NIM terakhir yang ditemukan
//             $nim_mhs = $maba_nim->nim + 1;
//         }

//         // Update NIM pendaftar
//         $pendaftar->update(['nim' => $nim_mhs]);

//         // Tingkatkan NIM untuk pendaftar berikutnya
//         $maba_nim = $pendaftar; // Update $maba_nim ke pendaftar saat ini
//     }

//     // Update nomor urut program studi
//     $nomer_urut->increment('nomer_urut_nim');

//     // Jika semua proses berhasil
//     return redirect()->back()->with('success', 'NIM berhasil di-generate untuk semua pendaftar yang dipilih.');
// }

// public function store(Request $request)
// {
//     // Ambil pendaftar yang belum memiliki NIM
//     $pendaftar = Pendaftar::where('nim', null)
//         ->whereHas('programStudi', function ($query) use ($request) {
//             $query->where('kode_nim', $request->kode_nim);
//         })
//         ->get();

//     // Debugging: Lihat hasil pendaftar
//     // dd($pendaftar);

//     // Cek apakah ada pendaftar yang ditemukan
//     if ($pendaftar->isEmpty()) {
//         return redirect()->back()->with('error', 'Tidak ada pendaftar yang belum memiliki NIM untuk kode_nim: ' . $request->kode_nim);
//     }

//     // Ambil pendaftar yang sudah memiliki NIM untuk menentukan NIM berikutnya
//     $maba_nim = Pendaftar::whereHas('detailPendaftar', function ($query) {
//             $query->where('nim', '!=', null);
//         })
//         ->whereHas('programStudi', function ($query) use ($request) {
//             $query->where('kode_nim', $request->kode_nim);
//         })
//         ->orderBy('nim', 'desc')
//         ->first();

//     // Debugging: Lihat hasil maba_nim
//     // dd($maba_nim);

//     // Ambil nomor urut dari program studi
//     $nomer_urut = ProgramStudi::where('kode_nim', $request->kode_nim)->first();

//     // Debugging: Lihat hasil nomer_urut
//     // dd($nomer_urut);

//     // Tentukan tahun masuk dan kode kampus
//     $tahun_masuk = date('Y');
//     $kode_kampus = 36;

//     // Cek apakah nomer_urut valid
//     if ($nomer_urut == null) {
//         return redirect()->back()->with('error', 'Nomor urut tidak ditemukan untuk kode_nim: ' . $request->kode_nim);
//     }

//     // Proses untuk setiap pendaftar yang belum memiliki NIM
//     foreach ($pendaftar as $p) {
//         // Tentukan NIM baru
//         if ($maba_nim == null || $maba_nim->nim == null) {
//             // Jika tidak ada NIM sebelumnya, buat NIM baru
//             $nim_mhs = $kode_kampus . substr($tahun_masuk, -2) . $request->kode_nim . str_pad($nomer_urut->nomer_urut_nim, 4, '0', STR_PAD_LEFT);
//         } else {
//             // Jika ada NIM sebelumnya, tambahkan 1
//             $nim_mhs = $maba_nim->nim + 1;
//         }

//         // Debugging: Lihat NIM yang dihasilkan
//         // dd($nim_mhs);

//         // Update NIM pendaftar
//         $p->update(['nim' => $nim_mhs]);

//         // Update maba_nim untuk iterasi berikutnya
//         $maba_nim = $p;
//         // Increment nomer_urut setelah setiap NIM dibuat
//         $nomer_urut->increment('nomer_urut_nim');
//     }

//     // Jika semua proses berhasil
//     return redirect()->back()->with('success', 'NIM berhasil di-generate untuk pendaftar yang belum memiliki NIM.');
// }



    
    
    
    
    
}