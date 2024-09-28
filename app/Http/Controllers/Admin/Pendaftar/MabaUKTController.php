<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use App\Models\Pendaftar;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class MabaUKTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $maba_ukt = Pendaftar::with('programStudi')->get();
        $gelombangPendaftaran = GelombangPendaftaran::all();
        $programStudi = ProgramStudi::get();
        $query = Pendaftar::query();
    
        // Tentukan relasi dan join yang diperlukan
        $query->with('gelombangPendaftaran', 'programStudi', 'detailPendaftar', 'refNegara', 'user')
            ->join('detail_pendaftars', 'pendaftars.id', '=', 'detail_pendaftars.pendaftar_id');
    
        // Filter berdasarkan gelombang
        if ($request->gelombang != '') {
            $query->where('gelombang_id', $request->gelombang);
        }
    
        // Filter berdasarkan program studi
        if ($request->prodi != '') {
            $query->where('program_studi_id', $request->prodi);
        }
    
        // Filter berdasarkan status UKT
        if ($request->statusukt != '') {
            $query->where('detail_pendaftars.status_ukt', $request->statusukt);
        }
    
        // Filter hanya status_pembayaran 'sudah'
        $query->where('detail_pendaftars.status_pembayaran', 'sudah'); // Menggunakan string 'sudah'
    
        // Ambil hasil query
        $maba_ukt = $query->get();
    
        // Cek apakah request berasal dari AJAX
        if ($request->ajax()) {
            return response()->json(['maba_ukt' => $maba_ukt]);
        }
    
        return view('admin.camaba.maba_sdh_ukt', compact('maba_ukt', 'gelombangPendaftaran', 'programStudi'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->id_pendaftar);
        $maba_nim = Pendaftar::whereHas('detailPendaftar', function ($query) {
            $query->where('nim', '!=', null);
        })
            ->whereHas('programStudi', function ($query) use ($request) {
                $query->where('kode_nim', $request->kode_nim);
            })->latest()->first();
        // dd($maba_nim->nim);
        $nomer_urut = ProgramStudi::where('kode_nim', $request->kode_nim)->first();
        $tahun_masuk = date('Y');
        // dd($nomer_urut);
        $kode_kampus = 36;
        // if ($maba_nim->nim == null) {
        //     $nim_mhs = $kode_kampus . substr($tahun_masuk, -2) . $request->kode_nim . $nomer_urut->nomer_urut_nim;
        // } else {
        //     $nim_mhs = $maba_nim->nim + 1;
        // }
        if ($maba_nim == null || $maba_nim->nim == null) {
            $nim_mhs = $kode_kampus . substr($tahun_masuk, -2) . $request->kode_nim . $nomer_urut->nomer_urut_nim;
        } else {
            $nim_mhs = $maba_nim->nim + 1;
        }

        // dd($nim_mhs);
        Pendaftar::where('id', $request->id_pendaftar)->update(['nim' => $nim_mhs]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
