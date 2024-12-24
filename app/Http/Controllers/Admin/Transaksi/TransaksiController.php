<?php

namespace App\Http\Controllers\Admin\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BerkasGelombangTransaksi;
use App\Models\GelombangProdiLain;
use App\Models\ProdiLain;

class TransaksiController extends Controller
{
    public function BerkasGelombang(Request $request)
    {

        // dd($id);
        // dd($request->nominal_ukt);
        // $pendaftarViaUKT = Pendaftar::find($id);
        // $pendaftarViaUKT->ukt_id = $request->ukt_id;
        // $pendaftarViaUKT->save();
        // return redirect()->back();

        $arr_berkas = $request->berkas;

        // Nonaktifkan semua berkas
        BerkasGelombangTransaksi::where('gelombang_id', $request->gelombang_id)->update(['hapus' => 1]);

        for ($i = 0; $i < count($arr_berkas); $i++) {

            // Set berkas yang aktif
            BerkasGelombangTransaksi::updateOrCreate([
                'gelombang_id' => $request->gelombang_id,
                'berkas_id' => $arr_berkas[$i]
            ]);

            BerkasGelombangTransaksi::where('berkas_id', $arr_berkas[$i])->update(['hapus' => 0]);
        }
        return redirect()->back();
    }

    public function ProdiLain(Request $request) {
        $request->validate([
            'prodi_lain_id' => 'required|array',
            'gelombang_id' => 'required'
        ]);
    
        $arr_prodilain = $request->prodi_lain_id;
    
        GelombangProdiLain::where('gelombang_id', $request->gelombang_id)->update(['hapus' => 1]);
    
        foreach ($arr_prodilain as $prodi_lain_id) {
            ProdiLain::updateOrCreate([
                'gelombang_id' => $request->gelombang_id,
                'prodi_lain_id' => $prodi_lain_id
            ], [
                'hapus' => 0 // atau sesuai kebutuhan
            ]);
        }
    }
    
}
