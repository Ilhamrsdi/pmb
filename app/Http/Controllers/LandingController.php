<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\GelombangPendaftaran;
use App\Models\Pendaftar;
use App\Models\Pengumuman;
use App\Models\RefJurusan;
// use App\Models\RefPorgramStudi;
use App\Models\TataCara;
use App\Models\AlurPendaftaran;
use App\Models\ProdiLain;
use App\Models\TanggalPenting;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Menggunakan caching untuk data yang jarang berubah
        $gelombang = GelombangPendaftaran::all(); // Caching tidak diterapkan karena data lebih dinamis
        $alurPendaftaran = Cache::remember('alur_pendaftaran', 60, function () {
            return AlurPendaftaran::first();
        });
        $prodi = Cache::remember('prodi', 60, function () {
            return ProgramStudi::with('jurusan')->get(); // Pastikan relasi 'jurusan' sudah terindeks dengan baik
        });
        $prodi_lain = Cache::remember('prodi_lain', 60, function () {
            return ProdiLain::all();
        });
        $tata_cara = Cache::remember('tata_cara', 60, function () {
            return TataCara::where('jenis', 'pendaftaran')->get();
        });
        $pengumuman = Cache::remember('pengumuman', 60, function () {
            return Pengumuman::take(5)->get();
        });
        $tanggal_penting = Cache::remember('tanggal_penting', 60, function () {
            return TanggalPenting::orderBy('tanggal_mulai')->get();
        });
        

        // Return data ke view
        return view('landing', compact([
            'gelombang',
            'prodi',
            'tata_cara',
            'pengumuman',
            'alurPendaftaran',
            'prodi_lain',
            'tanggal_penting',
        ]));
    }

    /**
     * Cek kode untuk validasi NIK dan Gelombang
     *
     * @return \Illuminate\Http\Response
     */
    public function cekkode(Request $request)
    {
        $cek_nik = $request->nik;

        // Optimasi query dengan hanya mengambil field yang dibutuhkan
        $cekkode = Pendaftar::whereHas('user', function ($query) use ($cek_nik) {
                $query->where('nik', '=', $cek_nik);
            })
            ->where('gelombang_id', $request->gelombang)
            ->first(['id', 'gelombang_id']); // Hanya ambil kolom yang diperlukan

        if ($cekkode) {
            $data = $cekkode->detailPendaftar->va_pendaftaran;
            return response()->json($data);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    /**
     * Menampilkan pengumuman berdasarkan ID
     *
     * @return \Illuminate\Http\Response
     */
    public function pengumuman($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumumans = Pengumuman::take(5)->get(); // Anda bisa mengganti ini dengan pagination jika banyak data
        return view('pengumuman', compact('pengumuman', 'pengumumans'));
    }

    /**
     * Halaman cek VA
     *
     * @return \Illuminate\Http\Response
     */
    public function cekVa(Request $request)
    {
        return view('pendaftar.cekva.index');
    }

    /**
     * Mendapatkan Program Studi berdasarkan Gelombang
     *
     * @return \Illuminate\Http\Response
     */
    public function getProdiByGelombang(Request $request)
    {
        $gelombangId = $request->input('gelombang_id');

        // Cari gelombang berdasarkan ID
        $gelombang = GelombangPendaftaran::find($gelombangId);
        if (!$gelombang) {
            return response()->json(['error' => 'Gelombang tidak ditemukan'], 404);
        }

        // Ambil data program_studi_1_ids
        $programStudiIds = json_decode($gelombang->program_studi_1ids);

        if (empty($programStudiIds)) {
            return response()->json(['error' => 'Tidak ada program studi pada gelombang ini'], 404);
        }

        // Mengambil data program studi dengan seleksi kolom yang diperlukan
        $prodi = RefPorgramStudi::whereIn('id', $programStudiIds)
            ->select('id', 'name') // Mengambil hanya kolom yang dibutuhkan
            ->get();

        return response()->json($prodi);
    }

    /**
     * Mendapatkan Program Studi 2 dan Prodi Lain
     *
     * @return \Illuminate\Http\Response
     */
    public function getProgramStudi2(Request $request)
    {
        $gelombangId = $request->input('gelombang_id');

        // Validasi apakah gelombang ID ada di database
        $gelombang = GelombangPendaftaran::find($gelombangId);
        if (!$gelombang) {
            return response()->json(['error' => 'Gelombang tidak ditemukan'], 404);
        }

        // Ambil data program_studi_2_ids dan decode JSON
        $programStudi2Ids = json_decode($gelombang->program_studi_2ids);

        if (!is_array($programStudi2Ids) || empty($programStudi2Ids)) {
            return response()->json(['error' => 'Tidak ada program studi 2 pada gelombang ini'], 404);
        }

        // Ambil data program studi berdasarkan ID dari tabel RefProgramStudi atau tabel terkait lainnya
        $programStudi2 = RefPorgramStudi::whereIn('id', $programStudi2Ids)
            ->select('id', 'name') // Ambil hanya kolom yang dibutuhkan
            ->get();

        // Ambil semua Prodi Lain
        $prodiLain = ProdiLain::select('id', 'name', 'kampus')->get();

        return response()->json([
            'program_studi_2' => $programStudi2,
            'prodi_lain' => $prodiLain
        ]);
    }
}
