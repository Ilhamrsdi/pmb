<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;

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
    
}
