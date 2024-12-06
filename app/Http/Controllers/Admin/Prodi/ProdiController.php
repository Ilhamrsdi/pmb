<?php

namespace App\Http\Controllers\Admin\Prodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\Jurusan;
use App\Models\RefPorgramStudi;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prodi = ProgramStudi::get();
        $jurusan = Jurusan::get();
        return view(
            'admin.prodi.prodi',
            compact(['prodi', 'jurusan'])
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

        $prodi = ProgramStudi::create([
            'jurusan_id' => $request->jurusan_id,
            'kode_program_studi' => $request->kode_program_studi,
            'nama_program_studi' => $request->nama_program_studi,
            'jenjang_pendidikan' => $request->jenjang_pendidikan,
            'akreditasi' => $request->akreditasi,
            'kode_nim' => $request->kode_nim,
            'nomer_urut_nim' => $request->nomer_urut_nim,
            'status' => $request->status,
        ]);

        return redirect()->route('prodi.index');
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

        
        $prodi = ProgramStudi::find($id)->update([
            'jurusan_id' => $request->jurusan_id,
            'kode_program_studi' => $request->kode_program_studi,
            'nama_program_studi' => $request->nama_program_studi,
            'jenjang_pendidikan' => $request->jenjang_pendidikan,
            'akreditasi' => $request->akreditasi,
            'kode_nim' => $request->kode_nim,
            'nomer_urut_nim' => $request->nomer_urut_nim,
            'status' => $request->status,
        ]);

        return redirect()->route('prodi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prodi = ProgramStudi::find($id);
        //$prodi->update([
        //     'hapus' => 1,
        // ]);

        $prodi->delete();
        return redirect()->route('prodi.index');
    }

    public function sync()
    {
        // id,code,name,acreditation,major_id,education_level_id
        $dataRef = RefPorgramStudi::with('jurusan', 'pendidikan')->get();
    
        // dd($dataRef);
    
        foreach ($dataRef as $value) {
    
            $status = null;
    
            if ($value->is_active) {
                $status = 'aktif';
            }
    
            ProgramStudi::updateOrCreate([
                'id' => $value->id,
                'jurusan_id' => $value->major_id,
                'kode_program_studi' => $value->code,
                'nama_program_studi' => $value->name,
                'jenjang_pendidikan' => $value->pendidikan ? $value->pendidikan->code . ' - ' . $value->pendidikan->name : 'No data',
                'akreditasi' => $value->acreditation,
                'status' => $status,
            ]);
        }
    
        return redirect()->route('prodi.index');
    }
    
}
