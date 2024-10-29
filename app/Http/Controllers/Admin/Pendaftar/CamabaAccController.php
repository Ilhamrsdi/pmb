<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\DetailPendaftar;
use App\Models\GelombangPendaftaran;
use App\Models\Pendaftar;
use App\Models\ProgramStudi;
use App\Models\Wali;
use Illuminate\Http\Request;

class CamabaAccController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $camaba_acc = Pendaftar::with('refNegara', 'detailPendaftar')->get();
        $gelombangPendaftaran = GelombangPendaftaran::all();
        $programStudi = ProgramStudi::get();
        $query = Pendaftar::query();
    
        // Tentukan kolom yang akan diambil, dan gunakan DISTINCT
        $query->select('pendaftars.*') 
            ->with('gelombangPendaftaran', 'programStudi', 'detailPendaftar', 'refNegara', 'user')
            ->join('detail_pendaftars', 'pendaftars.id', '=', 'detail_pendaftars.pendaftar_id')
            ->distinct(); // Menghindari duplikasi
    
        // Filter berdasarkan gelombang
        if ($request->gelombang != '') {
            $query->where('gelombang_id', $request->gelombang);
        }
    
        // Filter berdasarkan program studi
        if ($request->prodi != '') {
            $query->where('program_studi_id', $request->prodi);
        }
    
        // Filter berdasarkan status acc
        if ($request->statusacc != '') {
            $query->where('detail_pendaftars.status_acc', $request->statusacc);
        }
        
        if ($request->tanggal_daftar !='') {
            $query->where('detail_pendaftars.tanggal_daftar', $request->tanggal_daftar);
        }
        // Ambil hasil query
        $camaba_acc = $query->get();
    
        // Cek apakah request berasal dari AJAX
        if ($request->ajax()) {
            return response()->json(['camaba_acc' => $camaba_acc]);
        }
    
        return view('admin.camaba.camabaAcc', compact('camaba_acc', 'gelombangPendaftaran', 'programStudi'));
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
        //
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
        $camaba_acc = Pendaftar::find($id);
        $detailPendaftar = DetailPendaftar::where('pendaftar_id', $camaba_acc->id)->first();
        $detailPendaftar->status_acc = 'sudah';
        $detailPendaftar->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $camaba_acc = Pendaftar::find($id);
        $detailPendaftar = DetailPendaftar::where('pendaftar_id', $camaba_acc->id)->first();
        $wali = Wali::where('pendaftar_id', $camaba_acc->id)->first();
        $camaba_acc->delete();
        $detailPendaftar->delete();
        $wali->delete();
        // Alert::success('success', 'Data Berhasil Dihapus');
        return redirect()->back();
    }
}
