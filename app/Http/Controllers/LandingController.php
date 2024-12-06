<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\GelombangPendaftaran;
use App\Models\Pendaftar;
use App\Models\Pengumuman;
use App\Models\RefJurusan;
use App\Models\RefPorgramStudi;
use App\Models\TataCara;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gelombang = GelombangPendaftaran::get();
        // Memuat relasi jurusan saat mengambil program studi
        $prodi = RefPorgramStudi::with('jurusan')->get();
        $tata_cara = TataCara::where('jenis', 'pendaftaran')->get();
        $pengumuman = Pengumuman::get()->take(5);
        return view('landing', compact(['gelombang', 'prodi', 'tata_cara', 'pengumuman']));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function cekkode(Request $request)
    {
        // dd($request->gelombang);
        $cek_nik = $request->nik;
        $cekkode = Pendaftar::whereHas('user', function ($query) use ($cek_nik) {
            return $query->where('nik', '=', $cek_nik);
        })
            ->whereHas('detailPendaftar', function ($query) use ($cek_nik) {
                return $query->select('va_pendaftaran');
            })
            ->where('gelombang_id', $request->gelombang)
            ->first();
        // dd($cekkode);
        $data = $cekkode->detailPendaftar->va_pendaftaran;
        // dd($cekkode);
        return response()->json($data);
    }

    public function pengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumumans = Pengumuman::get()->take(5);
        return view('pengumuman', compact('pengumuman', 'pengumumans'));
    }


    public function cekVa(Request $request){
        return view('pendaftar.cekva.index');
    }
}
