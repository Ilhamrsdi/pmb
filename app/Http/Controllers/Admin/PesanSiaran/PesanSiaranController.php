<?php
namespace App\Http\Controllers\Admin\PesanSiaran;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\PesanSiaranMail; // Mail class

class PesanSiaranController extends Controller
{
    public function index()
    {
        $data = Pendaftar::whereHas('user', function ($query) {
            $query->where('role_id', 2); // Ambil pendaftar dengan role_id 2
        })->get();

        return view('admin.pesan_siaran.index', compact('data'));
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $pendaftar = Pendaftar::whereHas('user', function ($query) {
            $query->where('role_id', 2); // Ambil pendaftar dengan role_id 2
        })->first();

        if ($pendaftar) {
            $user = $pendaftar->user; // Ambil user dari relasi

            $mailData = [
                'title' => $request->subject,
                'body' => 'Pesan Siaran dari PMB POLIWANGI di bawah ini: ',
                'pesan' => $request->message,
            ];

            Mail::to($user->email)->send(new PesanSiaranMail($mailData));
        }

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}
