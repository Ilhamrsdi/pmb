<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\TesMaba;
use DB;

class SoalTesMabaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        // for ($i=0; $i < $request->jlm_soal; $i++) {
        //     array_push($arr_soal, $request->soal[$i]);
        //     array_push($arr_jawaban, $request->jawaban[$i]);
        // array_push($arr_jawaban, $request->JB[$i]);
        // array_push($arr_jawaban, $request->JC[$i]);
        // array_push($arr_jawaban, $request->JD[$i]);
        // $a[$i] = $request->soal[$i];
        // }


        $arr_soal = $request->soal;
        $arr_jawaban = $request->jawaban;
        $arr_jawaban1 = $request->jawaban1;
        $arr_jawaban2 = $request->jawaban2;
        $arr_jawaban3 = $request->jawaban3;
        // dd($arr_jawaban2);
        //     $data = [];
        //     foreach($arr_soal as $seat_id) {
        //         $Soal[] = array(
        //             'tes_maba_id' => $request->id_tes,
        //             'soal' => $arr_soal,
        //             'jawaban' => $arr_jawaban
        //         );
        //   Soal::insert(json_encode($data));

        for ($i = 0; $i < count($arr_soal); $i++) {
            $Soal[] = [
                'tes_maba_id' => $request->id_tes,
                'soal' => $arr_soal[$i],
                'jawaban' => $arr_jawaban[$i],
                'jawaban1' => $arr_jawaban1[$i],
                'jawaban2' => $arr_jawaban2[$i],
                'jawaban3' => $arr_jawaban3[$i],
            ];
        }
        if (Soal::where('tes_maba_id', $request->id_tes)->exists()) {

            Soal::where('tes_maba_id', $request->id_tes)->update($Soal);
        } else {
            Soal::insert($Soal);
        }

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
        $jumlah_soal = TesMaba::where('id', $id)->first();
        $soal = TesMaba::with('soal')->where('id', $id)->first();
        // dd($soal);

        return view('admin.camaba.soal_tes_maba', compact(['jumlah_soal', 'soal']));
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
        //
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
