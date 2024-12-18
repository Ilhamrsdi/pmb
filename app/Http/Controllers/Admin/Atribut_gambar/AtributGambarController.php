<?php
namespace App\Http\Controllers\Admin\Atribut_gambar;

use App\Models\Atribut;
use App\Models\AtributGambar;
use Illuminate\Http\Request;

class AtributGambarController
{
    /**
     * Store a newly created AtributGambar in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenis_gambar' => 'required|string|max:255',
            'nama_gambar'  => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
            'ukuran'       => 'nullable|string|max:255',
        ]);
    
        // Cek apakah ada file yang diunggah
        if ($request->hasFile('nama_gambar')) {
            // Ambil file
            $file = $request->file('nama_gambar');
            
            // Buat nama unik untuk file
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file ke folder public/uploads/atribut-gambars
            $file->move(public_path('uploads/atribut-gambars'), $filename);
            
            // Simpan metadata ke database
            // AtributGambar::create([
            //     'atribut_id'   => $request->atribut_id,
            //     'nama_gambar'  => $filename, // Nama file disimpan di database
            //     'jenis_gambar' => $request->jenis_gambar,
            //     'ukuran'       => $request->ukuran,
            // ]);
        }
    
        // Redirect kembali dengan pesan sukses
        return redirect()->route('atribut-gambars.index')->with('success', 'Gambar atribut berhasil ditambahkan.');
    }
    
    

    /**
     * Display a listing of the AtributGambar.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $atributGambars = AtributGambar::all();
        $atributs = Atribut::all(); // Mengambil semua data atribut
        // dd( $atributs);
        return view('admin.atribut-gambar.index', compact('atributGambars' , 'atributs'));
    }

    /**
     * Remove the specified AtributGambar from storage.
     *
     * @param  \App\Models\AtributGambar  $atributGambar
     * @return \Illuminate\Http\Response
     */
    public function destroy(AtributGambar $atributGambar)
    {
        $atributGambar->delete();
        return redirect()->back()->with('success', 'Gambar atribut berhasil dihapus.');
    }
    public function edit($id)
    {
        $atributGambar = AtributGambar::find($id);
        return response()->json($atributGambar);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_gambar' => 'required',
            'ukuran' => 'nullable|string',
        ]);

        $atributGambar = AtributGambar::find($id);

        if ($request->hasFile('nama_gambar')) {
            $path = $request->file('nama_gambar')->store('atribut-gambars', 'public');
            $atributGambar->nama_gambar = $path;
        }

        $atributGambar->jenis_gambar = $request->jenis_gambar;
        $atributGambar->ukuran = $request->ukuran;
        $atributGambar->save();

        return redirect()->route('atribut-gambars.index')->with('success', 'Gambar atribut berhasil diupdate.');
    }
}
