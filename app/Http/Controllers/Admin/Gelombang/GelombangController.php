<?php


namespace App\Http\Controllers\Admin\Gelombang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GelombangPendaftaran;
use App\Models\SettingBerkas;
use App\Models\BerkasGelombangTransaksi;
use App\Models\ProdiLain;
use App\Models\RefPorgramStudi;

class GelombangController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil data gelombang dengan ID tertentu
        $gelombang = GelombangPendaftaran::with('berkas')->orderBy('id', 'asc')->get();
        
        // Ambil Program Studi 1 dan Program Studi 2
        foreach ($gelombang as $g) {
            $programStudi1Ids = json_decode($g->program_studi_1ids); // Program Studi 1
            $programStudi2Ids = json_decode($g->program_studi_2ids); // Program Studi 2
            
            // Ambil nama program studi 1 dan 2 berdasarkan ID
            $programStudi1 = RefPorgramStudi::whereIn('id', $programStudi1Ids)->get();
           // Pastikan setiap ID adalah UUID yang valid
$validProgramStudi2Ids = array_filter($programStudi2Ids, function($id) {
    return \Ramsey\Uuid\Guid\Guid::isValid($id);
});

// Ambil data berdasarkan ID yang valid
$programStudi2 = ProdiLain::whereIn('id', $validProgramStudi2Ids)->get();

    
            // Menyimpan data nama program studi untuk ditampilkan di view
            $g->program_studi_1 = $programStudi1;
            $g->program_studi_2 = $programStudi2;
        }
    
        // Data lain yang tetap diambil
        $berkas = SettingBerkas::where('hapus', 0)->get();
        $prodiLain = ProdiLain::orderBy('name', 'asc')->get(); // Ambil data Prodi Lain
        $programStudis = RefPorgramStudi::orderBy('name', 'asc')->get();
        $allProdis = $programStudis->merge($prodiLain);
    
        // Kirim data ke view
        return view(
            'admin.gelombang.gelombang',
            compact('gelombang', 'berkas', 'allProdis', 'programStudis', 'prodiLain')
        );
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'program_studi_1' => 'required|array',
            'program_studi_2' => 'required|array',
            'prodi_lain_id' => 'nullable|uuid|exists:prodi_lain,id',
        ]);
    
        try {
            $gelombang = GelombangPendaftaran::create([
                'nama_gelombang' => $request->nama_gelombang,
                'tahun_ajaran' => $request->tahun_ajaran,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => $request->status,
                'deskripsi' => $request->deskripsi,
                'biaya_pendaftaran' => $request->biaya_pendaftaran,
                'biaya_administrasi' => $request->biaya_administrasi,
                'tanggal_ujian' => $request->tanggal_ujian,
                'tempat_ujian' => $request->tempat_ujian,
                'kuota_pendaftar' => $request->kuota_pendaftar,
                'program_studi_1ids' => json_encode($request->program_studi_1),
                'program_studi_2ids' => json_encode($request->program_studi_2),
                'prodi_lain_id' => $request->prodi_lain_id
            ]);
    
            // Set flash session jika sukses
            session()->flash('success', 'Gelombang pendaftaran berhasil ditambahkan.');
            return redirect()->route('gelombang.index');
        } catch (\Exception $e) {
            // Set flash session jika gagal
            session()->flash('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }
    
    
    
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gelombang = GelombangPendaftaran::find($id)->update([
            "nama_gelombang" => $request->nama_gelombang,
            "tahun_ajaran"  => $request->tahun_ajaran,
            "tanggal_mulai"  => $request->tanggal_mulai,
            "tanggal_selesai" => $request->tanggal_selesai,
            "status" => $request->status,
            "deskripsi"  => $request->deskripsi,
            "nominal_pendaftaran"  => $request->nominal_pendaftaran,
            "kuota_pendaftar"  => $request->kuota_pendaftar,
        ]);
        // dd($gelombang);

        return redirect()->route('gelombang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gelombang = GelombangPendaftaran::find($id);
        // $gelombang->update([
        //     'hapus' => 1,
        // ]);

        $gelombang->delete();
        return redirect()->route('gelombang.index');

        // dd($gelombang);
    }
}
