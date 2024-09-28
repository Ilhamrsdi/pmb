<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use App\Models\DetailPendaftar;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GrafikController extends Controller
{
    public function grafik_setahun(Request $request)
    {
        $tahun = $request->tahun;
        if ($tahun == NULL) {
            $tahun = Carbon::parse()->format('Y');
        }
        $pendaftar = DetailPendaftar::select(DB::raw('count(*) as data'), DB::raw('extract(month from created_at) as bulan'))
            ->where(DB::raw('extract(year from created_at)'), $tahun)
            ->groupBy('bulan')
            ->get()->toArray();

        $diterima = DetailPendaftar::select(DB::raw('count(*) as data'), DB::raw('extract(month from created_at) as bulan'))
            ->where(DB::raw('extract(year from created_at)'), $tahun)
            ->where('status_acc', 'sudah')
            ->groupBy('bulan')
            ->get()->toArray();

        $belum_diterima = DetailPendaftar::select(DB::raw('count(*) as data'), DB::raw('extract(month from created_at) as bulan'))
            ->where(DB::raw('extract(year from created_at)'), $tahun)
            ->whereNull('status_acc')
            ->groupBy('bulan')
            ->get()->toArray();

        $total_pendaftar = [];
        $total_diterima = [];
        $total_belum_diterima = [];

        for ($i = 0; $i < 12; $i++) {
            array_push($total_pendaftar, 0);
            array_push($total_diterima, 0);
            array_push($total_belum_diterima, 0);
        }

        foreach ($pendaftar as $value) {
            $total_pendaftar[$value['bulan'] - 1] = $value['data'];
        }

        foreach ($diterima as $value) {
            $total_diterima[$value['bulan'] - 1] = $value['data'];
        }

        foreach ($belum_diterima as $value) {
            $total_belum_diterima[$value['bulan'] - 1] = $value['data'];
        }

        $data = [
            'pendaftar' => $total_pendaftar,
            'diterima' => $total_diterima,
            'belum_diterima' => $total_belum_diterima,
        ];


        return $data;
    }

    public function grafik_sebulan(Request $request)
    {
        $filter = $request->filter;
        $bulan = Carbon::parse($filter)->format('m');
        $tahun = Carbon::parse($filter)->format('Y');

        $total_pendaftar = Pendaftar::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->get()->count();
        $total_belum_bayar_pendaftaran = DetailPendaftar::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->whereNull('status_pendaftaran')->get()->count();
        $total_belum_bayar_ukt = DetailPendaftar::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->whereNull('status_pembayaran')->get()->count();
        $total_diterima = DetailPendaftar::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->where('status_acc', 'sudah')->get()->count();
        $total_belum_diterima = DetailPendaftar::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->whereNull('status_acc')->get()->count();

        $data = [
            $total_pendaftar,
            $total_diterima,
            $total_belum_diterima,
            $total_belum_bayar_ukt,
            $total_belum_bayar_pendaftaran
        ];

        return $data;
    }
}
