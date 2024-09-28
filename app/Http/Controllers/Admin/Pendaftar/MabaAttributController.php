<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Atribut;
use App\Models\GelombangPendaftaran;
use App\Models\Pendaftar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MabaAttributController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $maba_attribut = Pendaftar::get();
        $gelombangPendaftaran = GelombangPendaftaran::get();
        $tahunAjaran = GelombangPendaftaran::select('tahun_ajaran')->groupBy('tahun_ajaran')->get();
        $maba_attribut = Pendaftar::with('detailPendaftar', 'gelombangPendaftaran', 'atribut', 'user')
            ->when(request()->gelombang, function ($maba_attribut) {
                if (request()->gelombang != '') {
                    $maba_attribut = $maba_attribut->where('gelombang_id', request()->gelombang);
                }
            })->when(request()->tahunajaran, function ($maba_attribut) {
                if (request()->tahunajaran != '') {
                    $maba_attribut->where('pmb.gelombang_pendaftarans.tahun_ajaran', request()->tahunajaran);
                }
            })->get();
        if ($request->ajax()) {
            $maba_attribut = Pendaftar::with('detailPendaftar', 'gelombangPendaftaran', 'atribut', 'user')
                ->when(request()->gelombang, function ($maba_attribut) {
                    if (request()->gelombang != '') {
                        $maba_attribut = $maba_attribut->where('gelombang_id', request()->gelombang);
                    }
                })->when(request()->tahunajaran, function ($maba_attribut) {
                    if (request()->tahunajaran != '') {
                        $maba_attribut->where('pmb.gelombang_pendaftarans.tahun_ajaran', request()->tahunajaran);
                    }
                })->get();
            return response()->json(['maba_attribut' => $maba_attribut]);
        }
        return view('admin.camaba.maba_attribut', compact('maba_attribut', 'gelombangPendaftaran', 'tahunAjaran'));
    }

    public function pdf(Request $request, $id)
    {
        // dd($request->all());
        $pendaftar = Pendaftar::find($id);
        $attribut = Atribut::where('pendaftar_id', $pendaftar->id)->first();
        $data = array(
            'nik' => $pendaftar->user->nik,
            'nama' => $pendaftar->nama,
            'gelombang' => $pendaftar->gelombangPendaftaran->nama_gelombang,
            'tahun_ajaran' => $pendaftar->gelombangPendaftaran->tahun_ajaran,
            'kaos' => $pendaftar->atribut->atribut_kaos,
            'topi' => $pendaftar->atribut->atribut_topi,
            'almamater' => $pendaftar->atribut->atribut_almamater,
            'jas_lab' => $pendaftar->atribut->atribut_jas_lab,
            'baju_lapangan' => $pendaftar->atribut->atribut_baju_lapangan
        );
        // dd($attribut);
        $pdf = Pdf::loadView('admin.camaba.maba_attribut_pdf', compact('pendaftar', 'attribut', 'data'))->setPaper('A4', 'potrait');
        return $pdf->download('maba-attribut.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateKaos(Request $request, $id)
    {
        // dd($request->all());
        $maba_attribut = Pendaftar::find($id);
        $attribut = Atribut::where('pendaftar_id', $maba_attribut->id)->first();
        if ($maba_attribut->atribut->status_pengambilan_kaos == null) {
            $attribut->status_pengambilan_kaos = 'sudah';
            $attribut->save();
        } elseif ($maba_attribut->atribut->status_pengambilan_kaos == 'sudah') {
            $attribut->status_pengambilan_kaos = null;
            $attribut->save();
        }
        return redirect()->back();
    }
    public function updateTopi(Request $request, $id)
    {
        $maba_attribut = Pendaftar::find($id);
        $attribut = Atribut::where('pendaftar_id', $maba_attribut->id)->first();
        if ($maba_attribut->atribut->status_pengambilan_topi == null) {
            $attribut->status_pengambilan_topi = 'sudah';
            $attribut->save();
        } elseif ($maba_attribut->atribut->status_pengambilan_topi == 'sudah') {
            $attribut->status_pengambilan_topi = null;
            $attribut->save();
        }
        return redirect()->back();
    }
    public function updateAlmamater(Request $request, $id)
    {
        $maba_attribut = Pendaftar::find($id);
        $attribut = Atribut::where('pendaftar_id', $maba_attribut->id)->first();
        if ($maba_attribut->atribut->status_pengambilan_almamater == null) {
            $attribut->status_pengambilan_almamater = 'sudah';
            $attribut->save();
        } elseif ($maba_attribut->atribut->status_pengambilan_almamater == 'sudah') {
            $attribut->status_pengambilan_almamater = null;
            $attribut->save();
        }
        return redirect()->back();
    }
    public function updateJasLab(Request $request, $id)
    {
        $maba_attribut = Pendaftar::find($id);
        $attribut = Atribut::where('pendaftar_id', $maba_attribut->id)->first();
        if ($maba_attribut->atribut->status_pengambilan_jas_lab == null) {
            $attribut->status_pengambilan_jas_lab = 'sudah';
            $attribut->save();
        } elseif ($maba_attribut->atribut->status_pengambilan_jas_lab == 'sudah') {
            $attribut->status_pengambilan_jas_lab = null;
            $attribut->save();
        }
        return redirect()->back();
    }
    public function updateBajuLapangan(Request $request, $id)
    {
        $maba_attribut = Pendaftar::find($id);
        $attribut = Atribut::where('pendaftar_id', $maba_attribut->id)->first();
        if ($maba_attribut->atribut->status_pengambilan_baju_lapangan == null) {
            $attribut->status_pengambilan_baju_lapangan = 'sudah';
            $attribut->save();
        } elseif ($maba_attribut->atribut->status_pengambilan_baju_lapangan == 'sudah') {
            $attribut->status_pengambilan_baju_lapangan = null;
            $attribut->save();
        }
        return redirect()->back();
    }
}
