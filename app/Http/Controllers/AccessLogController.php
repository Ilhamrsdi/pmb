<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{
    public function index()
    {
        // Ambil data log dengan pagination
        $logs = AccessLog::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.access-logs.index', compact('logs'));
    }
    public function destroy($id)
    {
        $log = AccessLog::findOrFail($id);  // Mengambil log berdasarkan ID
        $log->delete();  // Menghapus log
        
        return redirect()->route('access-logs.index')->with('success', 'Log has been deleted successfully.');
    }
    public function deleteAll(Request $request)
    {
        try {
            // Menghapus semua data log akses
            AccessLog::truncate();

            // Menampilkan pesan sukses
            return redirect()->route('access-logs.index')->with('success', 'Semua log berhasil dihapus.');
        } catch (\Exception $e) {
            // Menampilkan pesan error jika terjadi masalah
            return redirect()->route('access-logs.index')->with('error', 'Terjadi kesalahan, silakan coba lagi.');
        }
    }
    
}
