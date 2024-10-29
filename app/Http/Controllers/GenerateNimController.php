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
        
        // Cek semua data yang dikirim pada request
        $id_pendaftar = $request->id_pendaftar[0] ?? null; // Ambil nilai pertama dari array atau null jika kosong
        $kode_nim = $request->kode_nim ?? null;
    
        // Pastikan id_pendaftar dan kode_nim ada
        if (!$id_pendaftar || !$kode_nim) {
            return redirect()->back()->withErrors(['error' => 'ID pendaftar atau kode NIM tidak valid.']);
        }
    
        // Dapatkan pendaftar terakhir yang memiliki NIM sesuai kode NIM program studi
        $maba_nim = Pendaftar::where('nim', '!=', null)
            ->whereHas('programStudi', function ($query) use ($kode_nim) {
                $query->where('kode_nim', $kode_nim);
            })->latest()->first();
    
        // Pastikan kode NIM ada pada ProgramStudi
        $nomer_urut = ProgramStudi::where('kode_nim', $kode_nim)->first();
        if (!$nomer_urut) {
            return redirect()->back()->withErrors(['error' => 'Kode NIM tidak ditemukan pada program studi. Pastikan kode NIM yang dikirim benar.']);
        }
    
        $tahun_masuk = date('Y');
        $kode_kampus = 36;
    
        // Menentukan NIM mahasiswa baru
        if ($maba_nim == null) {
            $nim_mhs = $kode_kampus . substr($tahun_masuk, -2) . $kode_nim . $nomer_urut->nomer_urut_nim;
        } else {
            $nim_mhs = $maba_nim->nim + 1;
        }
    
        // Update NIM pada tabel Pendaftar
        $updated = Pendaftar::where('id', $id_pendaftar)->update(['nim' => $nim_mhs]);
    
        if ($updated) {
            return redirect()->back()->with('success', 'NIM berhasil di-generate dan diperbarui.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui NIM. Pastikan ID pendaftar valid.']);
        }
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