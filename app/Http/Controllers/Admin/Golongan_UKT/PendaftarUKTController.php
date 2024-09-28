<?php

namespace App\Http\Controllers\Admin\Golongan_UKT;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use App\Models\Pendaftar;
use App\Models\DetailPendaftar;
use App\Models\Ukt;
use Illuminate\Http\Request;

class PendaftarUKTController extends Controller
{
    public function listPendaftar(Ukt $ukt_id)
    {
        $golongan = Golongan::get();
        $listPendaftar = Pendaftar::where('ukt_id', $ukt_id)->get();
        // dd($listPendaftar);
        return view('admin.golongan_ukt.cobaPendaftar', compact('listPendaftar', 'golongan'));
    }
    public function pendaftarCreateUKT(Request $request)
    {

        // dd($id);
        // dd($request->nominal_ukt);
        // $pendaftarViaUKT = Pendaftar::find($id);
        // $pendaftarViaUKT->ukt_id = $request->ukt_id;
        // $pendaftarViaUKT->save();
        // return redirect()->back();

        $arr_pendaftar = $request->pendaftar;
        // dd($arr_pendaftar[0]);
        for ($i = 0; $i < count($arr_pendaftar); $i++) {

            // $Pendaftar = Pendaftar::where('tes_maba_id', $arr_pendaftar[$i]);
            // dd($arr_pendaftar[$i]);
            Pendaftar::where('id', $arr_pendaftar[$i])->update([
                'ukt_id' => $request->ukt_id,
            ]);
            DetailPendaftar::where('pendaftar_id', $arr_pendaftar[$i])->update([
                'status_ukt' => "sudah",
                'nominal_ukt' => $request->nominal_ukt,
            ]);
        }





        return redirect()->back();
    }
    public function pendaftarDeleteUKT(Request $request)
        {
            // dd($request->pendaftar);
            $hapus = Pendaftar::where('id', $request->pendaftar)->update([
            'ukt_id' => null,
            ]);
        return redirect()->back();
            
    }
}
