<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Pendaftar;

class PendaftarExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    use Exportable;

    public function collection()
    {
        // Mengambil data dengan relasi yang diperlukan untuk menampilkan nama
        return Pendaftar::with('programStudi', 'gelombangPendaftaran', 'detailPendaftar')->get()->map(function ($pendaftar) {
            return [
                'nama' => $pendaftar->nama,
                'gelombang' => $pendaftar->gelombangPendaftaran->nama_gelombang ?? 'Tidak Ada',  // Menampilkan nama gelombang
                'program_studi' => $pendaftar->programStudi->name ?? 'Tidak Ada',  // Menampilkan nama program studi
                'tanggal_daftar' => $pendaftar->detailPendaftar->tanggal_daftar ?? 'Tidak Ada',  // Menampilkan tanggal daftar
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Pendaftar', 
            'Gelombang Pendaftaran', 
            'Program Studi', 
            'Tanggal Daftar',
        ];
    }
}
