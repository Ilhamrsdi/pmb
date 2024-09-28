<?php

namespace App\Http\Controllers\Admin\PesanSiaran;

use App\Models\Pendaftar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PesanSiaranController extends Controller
{
    public function index()
    {
        $data = Pendaftar::get();
        return view('admin.pesan_siaran.index', compact('data'));
    }
}
