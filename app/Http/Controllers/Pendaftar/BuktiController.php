<?php

namespace App\Http\Controllers\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class BuktiController extends Controller
{

    // public function upload_bukti_pendaftaran(Request $request)
    // {
    //     $id = $request->id;
    //     $file = $request->bukti_bayar_pendaftaran;
    //     $nama =  $id . '.' . $file->extension();
    //     $file->move(public_path('assets/file/bukti-pendaftaran/'), $nama);

    //     return redirect(route('dashboard'));
    // }

    public function upload_bukti_pendaftaran(Request $request)
{
    $request->validate([
        'bukti_bayar_pendaftaran' => 'required|file|mimes:jpg,png,jpeg|max:2048', // Maksimal 2MB
    ]);

    $id = $request->id;
    $file = $request->file('bukti_bayar_pendaftaran'); // Pastikan metode ini dipakai
    $nama = $id . '.' . $file->extension();
    $directory = public_path('assets/file/bukti-pendaftaran/');

    // Daftar ekstensi yang didukung
    $extensions = ['jpg', 'png', 'jpeg'];

    // Cek dan hapus file lama jika ada
    foreach ($extensions as $ext) {
        $existingFile = $directory . $id . '.' . $ext;
        if (file_exists($existingFile)) {
            unlink($existingFile); // Menghapus file lama
        }
    }

    // Pindahkan file yang baru di-upload
    $file->move($directory, $nama);

    return redirect(route('dashboard'))->with('success', 'Bukti pembayaran berhasil diunggah.');
}



    public function upload_bukti_ukt(Request $request)
    {
        $id = $request->id;
        $file = $request->bukti_bayar_ukt;
        $nama =  $id . '.' . $file->extension();
        $file->move(public_path('assets/file/bukti-ukt/'), $nama);

        return redirect(route('dashboard'));
    }

    public function show($id)
    {
        $pendaftar = Pendaftar::where('id', $id)->with('user', 'detailPendaftar', 'programStudi', 'gelombangPendaftaran', 'ukt', 'atribut')->first();
        // dd($pendaftar);
        return view('pendaftar.bukti.show', compact('pendaftar'));
    }



    public function uploadBerkas(Request $request)
    {
        $berkasPath = 'assets/file_pendamping/';
        $namaBerkas = $request->input('nama_berkas'); // Pastikan 'nama_berkas' sesuai dengan form input
        $folder = $berkasPath . $namaBerkas; // Contoh: assets/file_pendamping/KK
    
        // Validasi file
        $request->validate([
            'assets.file_pendamping.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
    
        if ($request->hasFile('assets.file_pendamping')) {
            $file = $request->file('assets.file_pendamping');
            $fileName = time() . '_' . $file->getClientOriginalName();
    
            // Simpan file ke folder tujuan
            $path = $file->storeAs($folder, $fileName, 'public');
    
            // Simpan path ke database jika diperlukan
            // Misalnya: $berkasModel->path = $path; $berkasModel->save();
    
            return back()->with('success', 'Berkas berhasil diunggah!');
        }
    
        return back()->with('error', 'Tidak ada file yang diunggah!');
    }    


}
