<?php

namespace App\Http\Controllers\Admin\Prodi_lain;


use App\Models\ProdiLain;
use Illuminate\Http\Request;

class ProdiLainController 
{
    public function index()
    {
        // Tampilkan semua data dari tabel prodi_lains
        $prodiLain = ProdiLain::all();
        return view('admin.prodi_lain.index', compact('prodiLain'));
    }

    public function store(Request $request)
    {

        $gelombang = ProdiLain::create([
            "name" => $request->name,
            "kampus"  => $request->kampus,
            "alamat_kampus" => $request->alamat_kampus,
            "email_kampus"  => $request->email_kampus,
            'telepon_kampus' => $request->telepon_kampus,
            "website_kampus" => $request->website_kampus,
        ]);
        // dd($gelombang);

        return redirect()->route('prodi-lain.index')->with('success', ' Prodi Berhasil ditambahkan');

    }
    // public function edit(ProdiLain $prodiLain)
    // {
    //     // Form edit data
    //     return view('prodi_lain.edit', compact('prodiLain'));
    // }

    // public function update(Request $request, ProdiLain $prodiLain)
    // {
    //     // Validasi dan update data
    //     $request->validate([
    //         'nama_prodi' => 'required|string|max:255',
    //     ]);

    //     $prodiLain->update($request->all());
    //     return redirect()->route('prodi-lain.index')->with('success', 'Prodi berhasil diperbarui.');
    // }

    // public function destroy(ProdiLain $prodiLain)
    // {
    //     // Hapus data
    //     $prodiLain->delete();
    //     return redirect()->route('prodi-lain.index')->with('success', 'Prodi berhasil dihapus.');
    // }
}
