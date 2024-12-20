<?php


namespace App\Http\Controllers\Admin\Gelombang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GelombangPendaftaran;
use App\Models\SettingBerkas;
use App\Models\BerkasGelombangTransaksi;
use App\Models\ProdiLain;

class GelombangController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $gelombang = GelombangPendaftaran::with('berkas')->orderBy('id', 'asc')->get();
    //     $berkas = SettingBerkas::where('hapus', 0)->get();
    //     $prodiLain = ProdiLain::all();
    //     $selectedProdiLain = $gelombang->prodiLain()->pluck('prodi_lain_id')->toArray();

    //     return view(
    //         'admin.gelombang.gelombang',
    //         compact('gelombang', 'berkas', 'prodiLain', 'selectedProdiLain')
    //     );
    // }
    public function index()
    {
        $gelombang = GelombangPendaftaran::with('prodiLain')->orderBy('id', 'asc')->get();
        $berkas = SettingBerkas::where('hapus', 0)->get();
        $prodiLain = ProdiLain::all();
        $selectedProdiLain = $gelombang->mapWithKeys(function ($item) {
            return [$item->id => $item->prodiLain->pluck('id')->toArray()];
        });
    
        return view('admin.gelombang.gelombang', compact('gelombang', 'berkas', 'prodiLain', 'selectedProdiLain'));
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

        $gelombang = GelombangPendaftaran::create([
            "nama_gelombang" => $request->nama_gelombang,
            "tahun_ajaran"  => $request->tahun_ajaran,
            "tanggal_mulai"  => $request->tanggal_mulai,
            "tanggal_selesai" => $request->tanggal_selesai,
            "status" => $request->status,
            "deskripsi"  => $request->deskripsi,
            "biaya_pendaftaran"  => $request->biaya_pendaftaran,
            "biaya_administrasi" => $request->biaya_administrasi,
            "tanggal_ujian" => $request->tanggal_ujian,
            "tempat_ujian" => $request->tempat_ujian,
            "kuota_pendaftar"  => $request->kuota_pendaftar,
        ]);
        // dd($gelombang);

        return redirect()->route('gelombang.index');
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
    public function setProdiLain(Request $request, $id)
    {
        $gelombang = GelombangPendaftaran::findOrFail($id);
    
        // Update pivot table prodi_lain-gelombang
        $gelombang->prodiLain()->sync($request->input('prodi_lain_id', []));
    
        return redirect()->back()->with('success', 'Prodi Lain berhasil diperbarui!');
    }
    
    
    
    
}
