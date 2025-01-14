<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;  // Pastikan ini diimport
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Pendaftar;

class MabaSudhBayarExport implements FromCollection, WithHeadings  // Implementasikan WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Mengambil data dengan relasi yang diperlukan untuk menampilkan nama
        return Pendaftar::with('programStudi', 'gelombangPendaftaran', 'detailPendaftar')->get()->map(function ($pendaftar) {
            return [
                'nik' => $pendaftar->user->nik,
                'nama' => $pendaftar->nama,
                'nim' => $pendaftar->nim,
                'gelombang' => $pendaftar->gelombangPendaftaran->nama_gelombang ?? 'Tidak Ada',  // Menampilkan nama gelombang
                'program_studi' => $pendaftar->programStudi->name ?? 'Tidak Ada',  // Menampilkan nama program studi
                'tanggal_daftar' => $pendaftar->detailPendaftar->tanggal_daftar ?? 'Tidak Ada',  // Menampilkan tanggal daftar
                'status_mahasiswa' => $pendaftar->detailPendaftar->status_mahasiswa ?? 'tidak ada'
            ];
        });
    }

    // Menambahkan heading untuk kolom di file Excel
    public function headings(): array
    {
        return [
            'NIK',
            'Nama Pendaftar',
            'NIM', 
            'Gelombang Pendaftaran', 
            'Program Studi', 
            'Tanggal Daftar',
            'Status Mahasiswa'
        ];
    }
}
