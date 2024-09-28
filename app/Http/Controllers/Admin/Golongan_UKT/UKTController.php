<?php

namespace App\Http\Controllers\Admin\Golongan_UKT;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use App\Models\Ukt;
use Illuminate\Http\Request;

class UKTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.golongan_ukt.ukt');
        //
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
        Ukt::create([
            'golongan_id' => $request->golongan_id,
            'gelombang_pendaftaran_id' => $request->gelombang_pendaftaran_id,
            'nominal_reguler' => $request->nominal_reguler,
            'nominal_non_reguler' => $request->nominal_non_reguler,
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
        $ukt = UKT::find($id);
        $ukt->nominal_reguler = $request->nominal_reguler;
        $ukt->nominal_non_reguler = $request->nominal_non_reguler;
        $ukt->save();

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
        $ukt = Ukt::find($id);
        $ukt->delete();
        return redirect()->back();
    }
}
