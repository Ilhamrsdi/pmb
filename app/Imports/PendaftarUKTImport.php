<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Pendaftar;
use App\Models\DetailPendaftar;
use App\Models\Ukt;
class PendaftarUKTImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            // dd($row[1]);
            if ($key >= 1) {
         
                $pendaftar = Pendaftar::where('id', $row[0])->update([
                    'ukt_id' => $row[1],
                ]);
                // dd($pendaftar);
                $ukt = Ukt::where('id', $pendaftar)->first();
                // dd($ukt);
                DetailPendaftar::where('pendaftar_id', $row[0])->update([
                    'status_ukt' => "sudah",
                'nominal_ukt' => $ukt->nominal_reguler,
                ]);
            }
        }
    }
}
