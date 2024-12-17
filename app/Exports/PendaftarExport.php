<?php
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\Exportable;

class PendaftarExport implements FromCollection, WithHeadings, WithStrictNullComparison
{
    use Exportable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'NIK', 
            'Nama Pendaftar', 
            'NIM', 
            'Gelombang', 
            'Program Studi', 
            'Tanggal Daftar',
        ];
    }
}
