<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use App\Models\ProgramStudi;
use App\Models\RefPorgramStudi;

class LaporanController extends Controller
{
    public function laporan_penerimaan()
    {

        $data = Pendaftar::get();

        return view('admin.laporan.laporan-penerimaan', compact('data'));
    }

    public function laporan_pembayaran()
    {

        $data = Pendaftar::get();

        return view('admin.laporan.laporan-pembayaran', compact('data'));
    }

    public function grafik_provinsi(Request $request)
    {
        $query = DB::table('pendaftars')
            ->where('provinsi', '!=', null)
            ->select('provinsi', DB::raw('count(*) as total'))
            ->groupBy('provinsi');

        if ($request->gelombang != null) {
            $query->where('gelombang_id', $request->gelombang);
        }

        $data = $query->get()->toArray();
        $data_gelombang = GelombangPendaftaran::get();

        return view('admin.laporan.grafik-provinsi', compact('data', 'data_gelombang'));
    }

    public function grafik_prodi(Request $request)
    {
        // Query untuk menghitung total pendaftar berdasarkan prodi
        $query = DB::table('pendaftars')
            ->join('program_studis', 'pendaftars.program_studi_id', '=', 'program_studis.id')
            ->select('program_studis.nama_program_studi as prodi', DB::raw('count(*) as total'))
            ->groupBy('program_studis.id'); // Menggunakan id di program_studis
    
        // Jika ada filter berdasarkan gelombang
        if ($request->gelombang != null) {
            $query->where('gelombang_id', $request->gelombang);
        }
    
        // Ambil data hasil query
        $data = $query->get()->toArray();
    
        // Ambil data gelombang pendaftaran
        $data_gelombang = GelombangPendaftaran::get();
    
        // Ambil data program studi
        $data_prodi = RefPorgramStudi::all();
    
        // Persiapkan data untuk grafik
        $prodi_names = $data_prodi->pluck('nama_program_studi')->toArray(); // Nama-nama prodi
        $total_pendaftar = array_fill(0, count($prodi_names), 0); // Inisialisasi total pendaftar dengan 0
    
        // Sesuaikan total pendaftar untuk setiap program studi
        foreach ($data as $pendaftar) {
            $index = array_search($pendaftar->prodi, $prodi_names);
            if ($index !== false) {
                $total_pendaftar[$index] = $pendaftar->total; // Update jumlah pendaftar per prodi
            }
        }
    
        // Kirim data ke view
        return view('admin.laporan.grafik-prodi', compact('data', 'data_gelombang', 'prodi_names', 'total_pendaftar', 'data_prodi'));
    }
    
    
    
    
}
