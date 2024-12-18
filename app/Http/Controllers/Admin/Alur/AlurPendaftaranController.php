<?php

namespace App\Http\Controllers\Admin\Alur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlurPendaftaran; // Pastikan model sudah dibuat
use Illuminate\Support\Facades\Storage;

class AlurPendaftaranController extends Controller
{
    // Menampilkan daftar Alur Pendaftaran
    public function index()
    {
        $alur = AlurPendaftaran::all(); // Ambil semua data dari model
        return view('admin.alur-pendaftaran.index', compact('alur'));
    }

    // Menampilkan form tambah Alur Pendaftaran
    public function create()
    {
        return view('admin.alur-pendaftaran.create');
    }

    // Menyimpan data Alur Pendaftaran baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_alur' => 'required|string|max:255',
            'kriteria' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->only(['nama_alur', 'kriteria']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('alur_pendaftaran', 'public');
        }

        AlurPendaftaran::create($data); // Simpan data ke database
        return redirect()->route('alurPendaftaran')->with('success', 'Alur Pendaftaran berhasil ditambahkan.');
    }

    // Menampilkan form edit Alur Pendaftaran
    public function edit($id)
    {
        $alur = AlurPendaftaran::findOrFail($id); // Ambil data berdasarkan ID
        return view('admin.alur-pendaftaran.edit', compact('alur'));
    }

    // Mengupdate data Alur Pendaftaran
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_alur' => 'required|string|max:255',
            'kriteria' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $alur = AlurPendaftaran::findOrFail($id); // Ambil data berdasarkan ID
        $data = $request->only(['nama_alur', 'kriteria']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($alur->gambar) {
                Storage::disk('public')->delete($alur->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('alur_pendaftaran', 'public');
        }

        $alur->update($data); // Update data ke database
        return redirect()->route('alurPendaftaran')->with('success', 'Alur Pendaftaran berhasil diperbarui.');
    }

    // Menghapus data Alur Pendaftaran
    public function destroy($id)
    {
        $alur = AlurPendaftaran::findOrFail($id);

        if ($alur->gambar) {
            Storage::disk('public')->delete($alur->gambar);
        }

        $alur->delete(); // Hapus data dari database
        return redirect()->route('alurPendaftaran')->with('success', 'Alur Pendaftaran berhasil dihapus.');
    }
}
