<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use App\Models\ProgramStudi;

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
        $query = DB::table('pendaftars')
            ->join('program_studis', 'pendaftars.program_studi_id', 'program_studis.id')
            ->select('program_studis.nama_program_studi as prodi', DB::raw('count(*) as total'))
            ->groupBy('prodi');

        if ($request->gelombang != null) {
            $query->where('gelombang_id', $request->gelombang);
        }

        $data = $query->get()->toArray();

        $data_gelombang = GelombangPendaftaran::get();
        $data_prodi = ProgramStudi::get()->toArray();

        return view('admin.laporan.grafik-prodi', compact('data', 'data_gelombang', 'data_prodi'));
    }
}
