<?php

namespace App\Http\Controllers\Admin\CicilanPenurunanUKT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPendaftar;
use App\Models\TemplateDokumen;

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
    try {
        $cicilan = DetailPendaftar::findOrFail($id);

        // Validasi jika status sudah disetujui atau ditolak
        if ($cicilan->status_cicilan == 'disetujui' || $cicilan->status_cicilan == 'ditolak') {
            return redirect()->back()->with('error', 'Status cicilan sudah tidak bisa diubah.');
        }

        // Bersihkan format rupiah dari input
        $cicilanPertama = intval(str_replace('.', '', $request->input('cicilan_pertama')));
        $cicilanKedua = intval(str_replace('.', '', $request->input('cicilan_kedua')));
        $cicilanKetiga = intval(str_replace('.', '', $request->input('cicilan_ketiga')));
        $nominalUkt = intval(str_replace('.', '', $request->input('nominal_ukt')));

        // Validasi jumlah cicilan
        $totalCicilan = $cicilanPertama + $cicilanKedua + $cicilanKetiga;
        if ($totalCicilan !== $nominalUkt) {
            return redirect()->back()->with('error', 'Total cicilan harus sama dengan Nominal UKT.');
        }

        // Validasi data lainnya
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'status_cicilan' => 'required|in:pending,disetujui,ditolak',
        ]);

        // Update data cicilan
        $cicilan->update([
            'cicilan_pertama' => $cicilanPertama,
            'cicilan_kedua' => $cicilanKedua,
            'cicilan_ketiga' => $cicilanKetiga,
            'status_cicilan' => $validated['status_cicilan'],
        ]);

        // Mengarahkan kembali ke halaman dengan pesan sukses
        return redirect()->back()->with('success', 'Cicilan berhasil diperbarui');
    } catch (\Exception $e) {
        // Jika terjadi error, tangkap exception dan tampilkan pesan error
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
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


public function upload(Request $request)
{
    // Validasi file upload
    $request->validate([
        'file_path' => 'required|mimes:pdf,docx,doc,xlsx,xls|max:2048', // sesuaikan dengan tipe file yang diterima
    ]);

    try {
        // Ambil file dari request
        $file = $request->file('file_path');
        
        // Periksa apakah file ada
        if ($file) {
            // Simpan file ke folder public/assets/templates
            $fileName = 'template_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->move(public_path('assets/templates'), $fileName);

            // Simpan informasi ke database
            TemplateDokumen::create([
                'nama_dokumen' => $file->getClientOriginalName(),
                'file_path' => 'assets/templates/' . $fileName, // pastikan path disesuaikan dengan struktur folder Anda
            ]);
            
            return back()->with('success', 'Template berhasil diupload.');
        } else {
            return back()->with('error', 'File tidak ditemukan.');
        }
    } catch (\Exception $e) {
        // Tangkap exception dan tampilkan pesan error
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}








}
