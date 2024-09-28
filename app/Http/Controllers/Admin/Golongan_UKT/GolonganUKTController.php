<?php

namespace App\Http\Controllers\Admin\Golongan_UKT;

use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use App\Models\Golongan;
use App\Models\Pendaftar;
use App\Models\Ukt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GolonganUKTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $golongan = Golongan::get();
        return view('admin.golongan_ukt.golongan', compact('golongan'));
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
        Golongan::create([
            'nama_golongan' => $request->nama_golongan,
            'kriteria' => $request->kriteria,
        ]);
        return redirect()->back();
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
        $gelombangPendaftaran = GelombangPendaftaran::get();
        $golongan = Golongan::find($id);
        $ukt = Ukt::where('golongan_id', $golongan->id)->get();
        $listPendaftar = Pendaftar::whereHas('ukt', function ($query) use ($golongan) {
            $query->where('golongan_id', $golongan->id);
        })->get();
        // dd($listPendaftar);
        // $listPendaftar = Pendaftar::where('ukt_id', $ukt->id)->get();
        $nominal_ukt = Ukt::where('golongan_id', $golongan->id)->first();
        $addPendaftar = Pendaftar::where(function ($query) {
            $query->where('ukt_id', null)
                ->orWhere('ukt_id', 0);
        })->get();
        // $addPendaftar = Pendaftar::where('ukt_id', null)->where('ukt_id', 0)->get();
        // dd($addPendaftar);
        return view('admin.golongan_ukt.ukt', compact('golongan', 'ukt', 'gelombangPendaftaran', 'addPendaftar', 'listPendaftar', 'nominal_ukt'));
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
        $golongan = Golongan::find($id);
        $golongan->nama_golongan = $request->nama_golongan;
        $golongan->kriteria = $request->kriteria;
        $golongan->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $golongan = Golongan::find($id);
        $ukt = Ukt::where('golongan_id', $golongan->id)->first();
        $golongan->delete();
        $ukt->delete();
        return redirect()->back();
    }
}
