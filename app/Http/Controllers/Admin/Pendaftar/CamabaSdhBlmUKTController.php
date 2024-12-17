<?php


namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\DetailPendaftar;
use App\Models\GelombangPendaftaran;
use App\Models\Pendaftar;
use App\Models\ProgramStudi;
use App\Models\Wali;
use Illuminate\Http\Request;

class CamabaSdhBlmUKTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    // $camaba_ukt = Pendaftar::get();
    $gelombangPendaftaran = GelombangPendaftaran::all();
    $programStudi = ProgramStudi::get();
    $query = Pendaftar::query();

    // Relasi dan join yang diperlukan
    $query->with('gelombangPendaftaran', 'programStudi', 'detailPendaftar', 'refNegara', 'user')
        ->join('detail_pendaftars', 'pendaftars.id', '=', 'detail_pendaftars.pendaftar_id')
        ->distinct();

    // Filter berdasarkan gelombang pendaftaran
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

    // Filter hanya yang status_pembayaran 'belum'
    // $query->where('detail_pendaftars.status_pembayaran', $request->status_pembayaran); // Nilai status pembayaran 'belum'

    // Dapatkan hasil query
    $camaba_ukt = $query->get();
    
    // Handle request AJAX
    if ($request->ajax()) {
        return response()->json(['camaba_ukt' => $camaba_ukt]);
    }

    // return $camaba_ukt;
    return view('admin.camaba.camaba_sdh_blm_ukt', compact('camaba_ukt', 'gelombangPendaftaran', 'programStudi'));
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

    public function updateStatus(Request $request)
{
    $request->validate([
        'status_pembayaran' => 'required', // Validasi input
        'id' => 'required|exists:detail_pendaftars,id' // Pastikan ID pendaftar ada pada tabel detail_pendaftars
    ]);

    try {
        // Cari detail pendaftar berdasarkan ID
        $detailPendaftar = DetailPendaftar::findOrFail($request->id);

        // Update status pembayaran
        $detailPendaftar->update([
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        // Kembalikan response JSON jika request adalah AJAX, atau redirect kembali
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Status pembayaran berhasil diperbarui.']);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    } catch (\Exception $e) {
        \Log::error('Error updating status: ' . $e->getMessage());
        
        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui status.']);
        }

        return redirect()->back()->withErrors('Gagal memperbarui status.');
    }    
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
