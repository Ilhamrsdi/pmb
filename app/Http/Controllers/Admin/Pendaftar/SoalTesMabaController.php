<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Jawaban;
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
    public function index($id)
    {
        // Mengambil data tes berdasarkan ID
        $tesMaba = TesMaba::find($id);
    
        // Jika tes tidak ditemukan, lempar error atau redirect dengan pesan
        if (!$tesMaba) {
            return redirect()->back()->with('error', 'Tes tidak ditemukan.');
        }
    
        // Mengambil semua soal yang terkait dengan tes_maba_id
        $soals = Soal::where('tes_maba_id', $id)->get();
    
        // Menyediakan data tes dan soal ke view
        return view('pendaftar.ujian.soal', compact('tesMaba', 'soals'));
    }

    public function result(Request $request)
    {
        // Validasi input untuk memastikan pendaftar_id ada
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftars,id', // Pastikan validasi sesuai dengan kolom di tabel
        ]);

        // Mengambil hasil ujian berdasarkan ID pendaftar
        // Mengambil hasil ujian berdasarkan ID pendaftar
        $ujian = Soal::where('pendaftar_id', $request->pendaftar_id)->first();

        // Jika hasil ujian tidak ditemukan, kembalikan ke halaman sebelumnya dengan pesan
        if (!$ujian) {
            return redirect()->back()->with('error', 'Hasil ujian tidak ditemukan.');
        }

        // Mengambil semua detail hasil ujian yang terkait
        $examResults = $ujian->results; // Pastikan relasi ini ada di model HasilUjian

        // Kirim variabel ke view
        return view('pendaftar.ujian.result', compact('examResults')); // Hanya kirim examResults
    }
    
    
    // public function start($id)
    // {
    //   // Ambil data berdasarkan ID
    // $tesMaba = TesMaba::find($id);
    // $soals = Soal::where('tes_maba_id', $id)->get();
    // if (!$tesMaba) {
    //     // Jika data tidak ditemukan, bisa kembalikan 404
    //     abort(404);
    // }

    //     return view('pendaftar.ujian.soal', compact(['tesMaba','soals']));
    //     //
    // }
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
    // public function store(Request $request)
    // {

    //     // for ($i=0; $i < $request->jlm_soal; $i++) {
    //     //     array_push($arr_soal, $request->soal[$i]);
    //     //     array_push($arr_jawaban, $request->jawaban[$i]);
    //     // array_push($arr_jawaban, $request->JB[$i]);
    //     // array_push($arr_jawaban, $request->JC[$i]);
    //     // array_push($arr_jawaban, $request->JD[$i]);
    //     // $a[$i] = $request->soal[$i];
    //     // }


    //     $arr_soal = $request->soal;
    //     $arr_jawaban = $request->jawaban;
    //     $arr_jawaban1 = $request->jawaban1;
    //     $arr_jawaban2 = $request->jawaban2;
    //     $arr_jawaban3 = $request->jawaban3;
    //     // dd($arr_jawaban2);
    //     //     $data = [];
    //     //     foreach($arr_soal as $seat_id) {
    //     //         $Soal[] = array(
    //     //             'tes_maba_id' => $request->id_tes,
    //     //             'soal' => $arr_soal,
    //     //             'jawaban' => $arr_jawaban
    //     //         );
    //     //   Soal::insert(json_encode($data));

    //     for ($i = 0; $i < count($arr_soal); $i++) {
    //         $Soal[] = [
    //             'tes_maba_id' => $request->id_tes,
    //             'soal' => $arr_soal[$i],
    //             'jawaban' => $arr_jawaban[$i],
    //             'jawaban1' => $arr_jawaban1[$i],
    //             'jawaban2' => $arr_jawaban2[$i],
    //             'jawaban3' => $arr_jawaban3[$i],
    //         ];
    //     }
    //     if (Soal::where('tes_maba_id', $request->id_tes)->exists()) {

    //         Soal::where('tes_maba_id', $request->id_tes)->update($Soal);
    //     } else {
    //         Soal::insert($Soal);
    //     }

    //     return redirect()->back();
    // }
    public function store(Request $request)
{
    $arr_soal = $request->soal;
    $arr_jawaban = $request->jawaban;
    $arr_jawaban1 = $request->jawaban1;
    $arr_jawaban2 = $request->jawaban2;
    $arr_jawaban3 = $request->jawaban3;

    for ($i = 0; $i < count($arr_soal); $i++) {
        $data = [
            'tes_maba_id' => $request->id_tes,
            'soal' => $arr_soal[$i],
            'jawaban' => $arr_jawaban[$i],
            'jawaban1' => $arr_jawaban1[$i],
            'jawaban2' => $arr_jawaban2[$i],
            'jawaban3' => $arr_jawaban3[$i],
        ];

        // Cek jika soal sudah ada berdasarkan id_tes dan soal
        if (Soal::where('tes_maba_id', $request->id_tes)->where('soal', $arr_soal[$i])->exists()) {
            // Update soal yang sudah ada
            Soal::where('tes_maba_id', $request->id_tes)->where('soal', $arr_soal[$i])->update($data);
        } else {
            // Insert soal baru jika belum ada
            Soal::create($data);
        }
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
        // dd($jumlah_soal, $soal);

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
