<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\DetailPendaftar;
use App\Models\GelombangPendaftaran;
use App\Models\Pendaftar;
use App\Models\ProgramStudi;
use App\Models\Wali;
use Illuminate\Http\Request;

class PendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Mengambil data dari database untuk dropdown filter
        $gelombangPendaftaran = GelombangPendaftaran::all();
        $programStudi = ProgramStudi::all();
        
        // Membuat query dasar dengan relasi
        $query = Pendaftar::with('gelombangPendaftaran', 'programStudi', 'detailPendaftar');
    
        // Filter berdasarkan gelombang pendaftaran jika ada
        if ($request->gelombang) {
            $query->where('gelombang_id', $request->gelombang);
        }
    
        // Filter berdasarkan program studi jika ada
        if ($request->prodi) {
            $query->where('program_studi_id', $request->prodi);
        }
    
        // Filter berdasarkan status pendaftaran jika ada
        if ($request->status_acc) {
            $query->whereHas('detailPendaftar', function($q) use ($request) {
                $q->where('status_acc', $request->status_acc);
            });
        }
    
        // Filter berdasarkan status UKT jika ada
        if ($request->statusukt) {
            $query->whereHas('detailPendaftar', function($q) use ($request) {
                $q->where('status_ukt', $request->statusukt);
            });
        }
    
        // Mendapatkan hasil data dengan filter yang diterapkan
        $pendaftar = $query->get();
        
        // Mengembalikan response untuk permintaan AJAX
        if ($request->ajax()) {
            return response()->json(['pendaftar' => $pendaftar]);
        }
        // return $pendaftar;
        // Mengirimkan data ke view
        return view('admin.camaba.pendaftar', compact('pendaftar', 'gelombangPendaftaran', 'programStudi'));
    }

    /**
     * Update status pendaftaran using AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        // return $request->all();

        // $request->validate([
        //     'status_pendaftaran' => 'required', // Validasi input
        //     'id' => 'required|exists:pendaftars,id' // Pastikan ID pendaftar ada
        // ]);
        try {
            // Cari pendaftar dan detail pendaftar berdasarkan ID
            // $pendaftar = Pendaftar::findOrFail($request->id);
            $detailPendaftar = DetailPendaftar::findOrFail($request->id);
        
            // Update status pendaftaran
            $detailPendaftar->update([
                'status_pendaftaran' =>  $request->status_pendaftaran,
            ]);
            // $detailPendaftar->status_pendaftaran = $request->input('status_pendaftaran');
            // $detailPendaftar->save();
        
            // Mengembalikan response JSON
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error('Error updating status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui status.' . $e]);
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pendaftar = Pendaftar::find($id);
        $detailPendaftar = DetailPendaftar::where('pendaftar_id', $pendaftar->id)->first();
        $wali = Wali::where('pendaftar_id', $pendaftar->id)->first();

        // Hapus data pendaftar, detail pendaftar, dan wali
        if ($pendaftar) {
            $pendaftar->delete();
        }

        if ($detailPendaftar) {
            $detailPendaftar->delete();
        }

        if ($wali) {
            $wali->delete();
        }

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}
