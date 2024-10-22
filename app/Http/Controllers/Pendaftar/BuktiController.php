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
    $id = $request->id;
    $file = $request->bukti_bayar_pendaftaran;
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

    return redirect(route('dashboard'));
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
}
