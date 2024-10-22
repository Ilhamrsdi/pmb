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

        // $arr_pendaftar = $request->pendaftar;
        // // dd($arr_pendaftar[0]);
        // for ($i = 0; $i < count($arr_pendaftar); $i++) {

        //     // $Pendaftar = Pendaftar::where('tes_maba_id', $arr_pendaftar[$i]);
        //     // dd($arr_pendaftar[$i]);
        //     Pendaftar::where('id', $arr_pendaftar[$i])->update([
        //         'ukt_id' => $request->ukt_id,
        //     ]);
        //     DetailPendaftar::where('pendaftar_id', $arr_pendaftar[$i])->update([
        //         'status_ukt' => "sudah",
        //         'nominal_ukt' => $request->nominal_ukt,
        //     ]);
        // }
        $arr_pendaftar = $request->pendaftar;

// Pastikan $arr_pendaftar adalah array sebelum looping
if (is_array($arr_pendaftar) && count($arr_pendaftar) > 0) {
    for ($i = 0; $i < count($arr_pendaftar); $i++) {
        Pendaftar::where('id', $arr_pendaftar[$i])->update([
            'ukt_id' => $request->ukt_id,
        ]);

        DetailPendaftar::where('pendaftar_id', $arr_pendaftar[$i])->update([
            'status_ukt' => 'sudah',
            'nominal_ukt' => $request->nominal_ukt,
        ]);
    }
    return redirect()->back()->with('success', 'Data berhasil ditambahkan');
} else {
    // Tangani kasus jika $arr_pendaftar bukan array atau kosong
    return redirect()->back()->withErrors('Data pendaftar tidak valid.');
}
    }





    //     return redirect()->back();
    // }
//     public function pendaftarCreateUKT(Request $request)
// {
//     // Validasi input dari request
//     $validated = $request->validate([
//         'pendaftar' => 'required|array',
//         'pendaftar.*' => 'exists:pendaftars,id', // Memastikan id pendaftar valid
//         'ukt_id' => 'required|exists:ukts,id',  // Memastikan UKT ID valid
//         'nominal_ukt' => 'required|numeric',    // Memastikan nominal UKT adalah angka
//     ]);

//     // Ambil array pendaftar dari request
//     $arr_pendaftar = $validated['pendaftar'];
    
//     // Looping untuk update data pendaftar dan detail pendaftar
//     foreach ($arr_pendaftar as $pendaftar_id) {
//         // Update data di tabel Pendaftar
//         Pendaftar::where('id', $pendaftar_id)->update([
//             'ukt_id' => $validated['ukt_id'],
//         ]);

//         // Update data di tabel DetailPendaftar
//         DetailPendaftar::where('pendaftar_id', $pendaftar_id)->update([
//             'status_ukt' => 'sudah',
//             'nominal_ukt' => $validated['nominal_ukt'],
//         ]);
//     }

//     // Redirect kembali setelah proses selesai
//     return redirect()->back()->with('success', 'Data UKT berhasil diperbarui.');
// }

    public function pendaftarDeleteUKT(Request $request)
        {
            // dd($request->pendaftar);
            $hapus = Pendaftar::where('id', $request->pendaftar)->update([
            'ukt_id' => null,
            ]);
        return redirect()->back();
            
    }
}
