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
use App\Models\AlurPendaftaran;
use App\Models\ProdiLain;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil data dari database
        $gelombang = GelombangPendaftaran::get();
        $alurPendaftaran = AlurPendaftaran::first();
        $prodi = RefPorgramStudi::with('jurusan')->get();
        $prodi_lain = ProdiLain::get();
        $tata_cara = TataCara::where('jenis', 'pendaftaran')->get();
        $pengumuman = Pengumuman::take(5)->get();
    
        // Inisialisasi Guzzle client
        $client = new \GuzzleHttp\Client();
        $dataSekolah = []; // Inisialisasi variabel default
    
        try {
            // Request data SMA
            $responseSMA = $client->get('https://api-sekolah-indonesia.vercel.app/sekolah/sma?kab_kota=052500&page=1&perPage=1000');
            $dataSMA = json_decode($responseSMA->getBody(), true);
    
            // Request data SMK
            $responseSMK = $client->get('https://api-sekolah-indonesia.vercel.app/sekolah/smk?kab_kota=052500&page=1&perPage=1000');
            $dataSMK = json_decode($responseSMK->getBody(), true);
    
            // Gabungkan hasil SMA dan SMK jika data valid
            if (is_array($dataSMA) && isset($dataSMA['dataSekolah'])) {
                $dataSekolah = array_merge($dataSekolah, $dataSMA['dataSekolah']);
            }
    
            if (is_array($dataSMK) && isset($dataSMK['dataSekolah'])) {
                $dataSekolah = array_merge($dataSekolah, $dataSMK['dataSekolah']);
            }
    
            // Batasi jumlah data yang ditampilkan menjadi 100
            $dataSekolah = array_slice($dataSekolah, 0, 100);
    
        } catch (\Exception $e) {
            // Logging jika terjadi error
            \Log::error('Error fetching SMA dan SMK data: ' . $e->getMessage());
        }
    
        // Return data ke view
        return view('landing', compact([
            'gelombang',
            'prodi',
            'tata_cara',
            'pengumuman',
            'alurPendaftaran',
            'prodi_lain',
            'dataSekolah'
        ]));
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
    
    public function getProdiByGelombang(Request $request)
{
    $gelombangId = $request->input('gelombang_id');

    // Cari gelombang berdasarkan ID
    $gelombangId = $request->input('gelombang_id');
    \Log::info('Gelombang ID:', [$gelombangId]);

    $gelombang = GelombangPendaftaran::find($gelombangId);
    if (!$gelombang) {
        return response()->json(['error' => 'Gelombang tidak ditemukan'], 404);
    }

    \Log::info('Data Gelombang:', [$gelombang]);

    $programStudiIds = json_decode($gelombang->program_studi_1ids);
    \Log::info('Program Studi IDs:', [$programStudiIds]);

    if (empty($programStudiIds)) {
        return response()->json(['error' => 'Tidak ada program studi pada gelombang ini'], 404);
    }

    $prodi = RefPorgramStudi::whereIn('id', $programStudiIds)->get();
    \Log::info('Program Studi:', [$prodi]);

    return response()->json($prodi);
}
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

    // Validasi apakah hasil decode adalah array yang valid
    if (!is_array($programStudi2Ids) || empty($programStudi2Ids)) {
        return response()->json(['error' => 'Tidak ada program studi 2 pada gelombang ini'], 404);
    }

    // Ambil data program studi berdasarkan ID dari tabel RefProgramStudi atau tabel terkait lainnya
    $programStudi2 = RefPorgramStudi::whereIn('id', $programStudi2Ids)->get(['id', 'name']);
    
    // Ambil semua Prodi Lain
    $prodiLain = ProdiLain::all(['id', 'name', 'kampus']);

    // Jika tidak ada program studi ditemukan
    if ($programStudi2->isEmpty()) {
        return response()->json(['error' => 'Program studi 2 tidak ditemukan'], 404);
    }

    // Kembalikan data program studi dalam bentuk JSON
    return response()->json([
        'program_studi_2' => $programStudi2,
        'prodi_lain' => $prodiLain
    ]);
}




}
