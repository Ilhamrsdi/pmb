<?php

namespace App\Http\Controllers\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class BuktiController extends Controller
{
    public function upload_bukti_pendaftaran(Request $request)
    {
        $id = $request->id;
        $file = $request->bukti_bayar_pendaftaran;
        $nama =  $id . '.' . $file->extension();
        $file->move(public_path('assets/file/bukti-pendaftaran/'), $nama);

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
