<?php

namespace App\Http\Controllers\Admin\CicilanPenurunanUKT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPendaftar;

class CicilanUktPenurunanController extends Controller
{
    //
    // public function index(){
    //     return view('admin.cicilan-penurunan-ukt.index');
    // }
    public function index()
{
    // Ambil data dari tabel DetailPendaftar
    $cicilan = DetailPendaftar::with('pendaftar')->get();

    // Kirim data ke view
    return view('admin.cicilan-penurunan-ukt.index', compact('cicilan'));
}
public function update(Request $request, $id)
{
    $cicilan = DetailPendaftar::findOrFail($id);

    // Validasi jika status sudah disetujui atau ditolak
    if ($cicilan->status_cicilan == 'disetujui' || $cicilan->status_cicilan == 'ditolak') {
        return redirect()->back()->with('error', 'Status cicilan sudah tidak bisa diubah.');
    }

    // Validasi dan update data
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'nominal_ukt' => 'required|numeric',
        'status_cicilan' => 'required|in:pending,disetujui,ditolak',
    ]);

    $cicilan->update($validated);

    return redirect()->back()->with('success', 'Cicilan berhasil diperbarui');
}

public function destroy($id)
{
    $cicilan = DetailPendaftar::findOrFail($id);

    // Validasi jika status sudah disetujui atau ditolak
    if ($cicilan->status_cicilan == 'disetujui' || $cicilan->status_cicilan == 'ditolak') {
        return redirect()->back()->with('error', 'Data cicilan tidak dapat dihapus.');
    }

    // Hapus data
    $cicilan->delete();

    return redirect()->back()->with('success', 'Cicilan berhasil dihapus');
}
public function updateStatus(Request $request, $id)
{
    $cicilan = DetailPendaftar::findOrFail($id);

    // Validasi input status cicilan
    $request->validate([
        'status_cicilan' => 'required|in:pending,disetujui,ditolak',
    ]);

    // Update status cicilan
    $cicilan->status_cicilan = $request->status_cicilan;
    $cicilan->save();

    return redirect()->back()->with('success', 'Status cicilan berhasil diperbarui');
}



}
