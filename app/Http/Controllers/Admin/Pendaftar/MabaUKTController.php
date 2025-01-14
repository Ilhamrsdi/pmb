<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use App\Models\Pendaftar;
use App\Models\ProgramStudi;
use App\Models\RefPorgramStudi;
use Illuminate\Http\Request;
use App\Exports\MabaSudhBayarExport;
use Maatwebsite\Excel\Facades\Excel;


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
        $programStudi = RefPorgramStudi::get();
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
        // Ambil data pendaftar beserta program studi
        $pendaftar = Pendaftar::with('programStudi')->find($request->id_pendaftar);
    
        if (!$pendaftar || !$pendaftar->programStudi) {
            return back()->with('error', 'Program Studi atau Pendaftar tidak ditemukan!');
        }
    
        // Ambil kode dari kolom 'code' di tabel Program Studi
        $kode_nim = $pendaftar->programStudi->code;
    
        // Debug kode_nim untuk memastikan
        // dd($kode_nim);
    
        // Kode kampus dan tahun masuk
        $kode_kampus = 36;
        $tahun_masuk = date('Y');
    
        // Ambil angka belakang dari kode_nim (misal 21401 -> ambil "401")
        $kode_belakang_prodi = substr($kode_nim, -3);
    
        // Ambil nomor urut terakhir berdasarkan program studi (kode_nim)
        $maba_nim = Pendaftar::whereHas('programStudi', function ($query) use ($kode_nim) {
            $query->where('code', $kode_nim);
        })->latest()->first();
    
        // Tentukan nomor urut baru
        $nomor_urut_baru = 1; // Default nomor urut awal jika belum ada data
        if ($maba_nim && $maba_nim->nim) {
            // Ambil 4 digit terakhir dari NIM sebelumnya dan tambahkan 1
            $nomor_urut_baru = (int) substr($maba_nim->nim, -4) + 1;
        }
    
        // Generate NIM
        $nim_mhs = $kode_kampus
            . substr($tahun_masuk, -2)
            . $kode_belakang_prodi
            . str_pad($nomor_urut_baru, 4, '0', STR_PAD_LEFT);
    
        // Update NIM ke database
        $pendaftar->update(['nim' => $nim_mhs]);
        $pendaftar->detailPendaftar->update(['status_mahasiswa' => 'aktif']);
    
        return back()->with('success', 'NIM berhasil di-generate!');
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
    public function exportToExcel(Request $request)
    {
        // Jika Anda ingin mengirim data khusus ke export
       
    
        // Menjalankan export
        return Excel::download(new MabaSudhBayarExport(), 'maba_sudahBayar.xlsx');
    }
}
