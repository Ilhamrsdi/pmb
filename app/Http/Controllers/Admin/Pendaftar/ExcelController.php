<?php

namespace App\Http\Controllers\Admin\Pendaftar;

use App\Http\Controllers\Controller;
use App\Imports\PendaftarImport;
use App\Imports\PendaftarUKTImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('file');
        Excel::import(new PendaftarImport, $file);
        return redirect()->back();
    }
    public function import_ukt(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        if ($request->file->getClientOriginalName() == 'Pendaftar_ukt.xlsx') {
        //    dd( $request->file('file'));
           $file = $request->file('file');
           Excel::import(new PendaftarUKTImport, $file);
           return redirect()->back();
        }
        // return redirect()->back();
       
    }
}
