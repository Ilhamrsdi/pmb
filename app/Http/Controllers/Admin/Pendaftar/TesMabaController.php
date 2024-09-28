<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TesMaba;

class TesMabaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tes_maba = TesMaba::get();
        return view('admin.camaba.tes_maba', compact('tes_maba'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        TesMaba::create([
                'kode_mapel' => $request->kode_mapel,
              'nama_mapel' => $request->nama_mapel,
              'jumlah_soal'=> $request->jumlah_soal,
              'tanggal_tes' => $request->tanggal_tes,
              'waktu_tes' => $request->waktu_tes,
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
        TesMaba::find($id)->update([
            'kode_mapel' => $request->kode_mapel,
          'nama_mapel' => $request->nama_mapel,
          'jumlah_soal'=> $request->jumlah_soal,
          'tanggal_tes' => $request->tanggal_tes,
          'waktu_tes' => $request->waktu_tes,
    ]);
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
        //
    }
}
