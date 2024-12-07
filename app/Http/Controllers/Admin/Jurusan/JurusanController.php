<?php

namespace App\Http\Controllers\Admin\Jurusan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\RefJurusan;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jurusan = Jurusan::get();
        return view(
            'admin.jurusan.jurusan',
            compact('jurusan')
        );
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
        // dd($request);

        $jurusan = Jurusan::create([
            "kode_jurusan"  => $request->kode_jurusan,
            "nama_jurusan" => $request->nama_jurusan,
            // "tanggal_mulai"  => $request->tanggal_mulai,
            // "tanggal_selesai" => $request->tanggal_selesai,
            // "status" => $request->status,
            // "deskripsi"  => $request->deskripsi,
            // "nominal_pendaftaran"  => $request->nominal_pendaftaran,
        ]);

        return redirect()->route('jurusan.index');
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
        $jurusan = Jurusan::find($id)->update([
            "kode_jurusan"  => $request->kode_jurusan,
            "nama_jurusan" => $request->nama_jurusan,
            // "tanggal_mulai"  => $request->tanggal_mulai,
            // "tanggal_selesai" => $request->tanggal_selesai,
            // "status" => $request->status,
            // "deskripsi"  => $request->deskripsi,
            // "nominal_pendaftaran"  => $request->nominal_pendaftaran,
        ]);

        return redirect()->route('jurusan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jurusan = Jurusan::find($id);
        //$jurusan->update([
        //     'hapus' => 1,
        // ]);

        $jurusan->delete();
        return redirect()->route('jurusan.index');
    }

    // public function sync()
    // {

    //     $dataRef = RefJurusan::get();

    //     foreach ($dataRef as  $value) {

    //         $status = null;

    //         if ($value->is_active) {
    //             $status = 'aktif';
    //         }

    //         Jurusan::updateOrCreate([
    //             'id' => $value->id,
    //             'nama_jurusan' => $value->name,
    //             'alias_jurusan' => $value->alias,
    //             'status' => $status
    //         ]);
    //     }

    //     return redirect()->route('jurusan.index');
    // }
    public function sync()
    {
        // Ambil data terbaru dari database
        $dataRef = RefJurusan::get();// Atau logika sinkronisasi dari API eksternal
    
        // Kembalikan data ke AJAX dalam bentuk JSON atau HTML
        return response()->json([
            'success' => true,
            'data' => $dataRef,
            'message' => 'Data berhasil disinkronisasi!'
        ]);
    }

}
