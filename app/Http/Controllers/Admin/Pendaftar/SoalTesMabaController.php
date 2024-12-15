<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\TesMaba;
use Illuminate\Support\Facades\DB;

class SoalTesMabaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // Validasi: pastikan ID adalah angka
        if (!is_numeric($id)) {
            return redirect()->back()->with('error', 'ID tidak valid.');
        }
    
        // Mengambil data tes berdasarkan ID
        $tesMaba = TesMaba::find($id);
        if (!$tesMaba) {
            return redirect()->back()->with('error', 'Tes tidak ditemukan.');
        }
    
        // Ambil data soal dengan relasi
        $soals = Soal::where('tes_maba_id', $id)->with('tesMaba')->get();
        dd($soals); // Tambahkan dump untuk memeriksa data soal
    
        $pendaftar_id = auth()->user()->id;
    
        return view('pendaftar.ujian.soal', compact('tesMaba', 'soals', 'pendaftar_id'));
    }
    
    
    
    

    /**
     * Menampilkan hasil ujian berdasarkan pendaftar_id.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {
        // Validasi input untuk memastikan pendaftar_id ada
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftars,id', // Pastikan validasi sesuai dengan kolom di tabel
        ]);

        // Mengambil hasil ujian berdasarkan ID pendaftar
        $ujian = Jawaban::where('pendaftar_id', $request->pendaftar_id)->first();

        // Jika hasil ujian tidak ditemukan, kembalikan ke halaman sebelumnya dengan pesan
        if (!$ujian) {
            return redirect()->back()->with('error', 'Hasil ujian tidak ditemukan.');
        }

        // Mengambil semua detail hasil ujian yang terkait
        $examResults = $ujian->results; // Pastikan relasi ini ada di model Jawaban

        // Kirim variabel ke view
        return view('pendaftar.ujian.result', compact('examResults'));
    }

    /**
     * Menyimpan jawaban ujian.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAnswers(Request $request)
    {
        $dataJawaban = $request->answers; // Mengambil jawaban dari request
    
        foreach ($dataJawaban as $soal_id => $jawaban) {
            Jawaban::updateOrCreate(
                [
                    'pendaftar_id' => $request->pendaftar_id, // ID pendaftar
                    'soal_id' => $soal_id, // ID soal
                ],
                [
                    'jawaban' => $jawaban, // Menyimpan jawaban
                    'status' => 1, // Set status menjadi 1 setelah ujian
                ]
            );
        }
    
        return response()->json(['message' => 'Jawaban berhasil disimpan.'], 200);
    }
    

    /**
     * Menyimpan data soal.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'soal' => 'required|array',
            'jawaban' => 'required|array',
            'id_tes' => 'required|exists:tes_mabas,id',
        ]);

        $arr_soal = $request->soal;
        $arr_jawaban = $request->jawaban;
        $arr_jawaban1 = $request->jawaban1 ?? [];
        $arr_jawaban2 = $request->jawaban2 ?? [];
        $arr_jawaban3 = $request->jawaban3 ?? [];

        for ($i = 0; $i < count($arr_soal); $i++) {
            $data = [
                'tes_maba_id' => $request->id_tes,
                'soal' => $arr_soal[$i],
                'jawaban' => $arr_jawaban[$i],
                'jawaban1' => $arr_jawaban1[$i] ?? null,
                'jawaban2' => $arr_jawaban2[$i] ?? null,
                'jawaban3' => $arr_jawaban3[$i] ?? null,
            ];

            // Cek jika soal sudah ada berdasarkan id_tes dan soal
            Soal::updateOrCreate(
                [
                    'tes_maba_id' => $request->id_tes,
                    'soal' => $arr_soal[$i]
                ],
                $data
            );
        }

        return redirect()->back()->with('success', 'Data soal berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jumlah_soal = TesMaba::where('id', $id)->first();
        $soal = TesMaba::with('soal')->where('id', $id)->first();

        return view('admin.camaba.soal_tes_maba', compact(['jumlah_soal', 'soal']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
