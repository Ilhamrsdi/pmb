<?php

namespace App\Http\Controllers\Admin\Berkas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingBerkas;
// use File;
use Illuminate\Support\Facades\File;


class SettingBerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $berkas = SettingBerkas::where('hapus', 0)->get();
        // $url_path = public_path().'/Setting Berkas/';
        // $url_path = str_replace("/", "\\", $url_path);
        return view(
            'admin.setting_berkas.berkas',
            compact(['berkas'])
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

        $path = public_path() . '/file_pendamping/' . $request->path;
        File::makeDirectory($path, $mode = 0777, true, true);
        $berkas = SettingBerkas::create([
            "nama_berkas" => $request->nama_berkas,
            "path"  => $request->path,
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
        $path = public_path() . '/file_pendamping/' . $request->path;
        File::makeDirectory($path, $mode = 0777, true, true);
        $berkas = SettingBerkas::where('id', $id)->update([
            "nama_berkas" => $request->nama_berkas,
            "path"  => $request->path,
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
        $gelombang = SettingBerkas::where('id', $id)->update([
            "hapus" => 1,
        ]);
        // $path = public_path().'/Setting Berkas/' . $request->path;
        // File::makeDirectory($path, $mode = 0777, true, true);

        // dd($gelombang);

        return redirect()->back();
    }
}
