<?php

namespace App\Http\Controllers\Pendaftar;

use App\Models\Wali;
use App\Models\Atribut;
use App\Models\RefAgama;
use App\Models\Pendaftar;
use App\Models\RefRegion;
use App\Models\RefCountry;
use App\Models\RefProfesi;
use App\Models\RefKendaraan;
use Illuminate\Http\Request;
use App\Models\RefPendapatan;
use App\Models\RefPendidikan;
use App\Models\SettingBerkas;
use App\Models\RefTempatTinggal;
use App\Http\Controllers\Controller;
use App\Models\BerkasGelombangTransaksi;
use Symfony\Component\HttpKernel\Exception\HttpException;

class KelengkapanDataController extends Controller
{
    public function edit($id)
    {
        $pendaftar = Pendaftar::where('id', $id)->with('user', 'atribut')->first();

        // Form Biodata Diri
        $kendaraan = RefKendaraan::get();
        $tempat_tinggal = RefTempatTinggal::get();
        $negara = RefCountry::orderBy('name')->get();
        $provinsi = RefRegion::where('level', 1)->get();
        $kabupaten_kota = RefRegion::where('level', 2)->get();
        $kecamatan = RefRegion::where('level', 3)->get();
        $agama = RefAgama::get();
        $ukuran = ['s', 'm', 'l', 'xl', 'xxl'];

        // Form Biodata Orang Tua
        $pendidikan = RefPendidikan::get();
        $profesi = RefProfesi::get();
        $pendapatan = RefPendapatan::get();

        // Form Berkas Pendukung
        $list_berkas = BerkasGelombangTransaksi::where('gelombang_id', $pendaftar->gelombang_id)->with('berkas')->get();

        return view('pendaftar.kelengkapan-data.kelengkapan-data', compact('pendaftar', 'kendaraan', 'tempat_tinggal', 'negara', 'provinsi', 'kabupaten_kota', 'kecamatan', 'agama', 'ukuran', 'pendidikan', 'profesi', 'pendapatan', 'list_berkas'));
    }

    public function update(Request $request, $id)
    {

        // Update Data Pendaftar
        $pendaftar = Pendaftar::where('id', $id)->update([
            "nama"              => $request->nama,
            "nisn"              => $request->nisn,
            "sekolah"           => $request->sekolah,
            "alamat"            => $request->alamat,
            "jenis_tinggal"     => $request->jenis_tinggal,
            "kendaraan"         => $request->kendaraan,
            "kewarganegaraan"   => $request->kewarganegaraan,
            "negara"            => $request->negara,
            "provinsi"          => $request->provinsi,
            "kabupaten"         => $request->kabupaten,
            "kecamatan"         => $request->kecamatan,
            "kelurahan_desa"    => $request->kelurahan_desa,
            "rt"                => $request->rt,
            "rw"                => $request->rw,
            "kode_pos"          => $request->kode_pos,
            "no_hp"             => $request->no_hp,
            "telepon_rumah"     => $request->telepon_rumah,
            "tempat_lahir"      => $request->tempat_lahir,
            "tanggal_lahir"     => $request->tanggal_lahir,
            "agama"             => $request->agama,
        ]);

        // Update Data Orang Tua
        $wali = Wali::where('pendaftar_id', $id)->update([
            "nik_ayah"            => $request->nik_ayah,
            "status_ayah"         => $request->status_ayah,
            "nama_ayah"           => $request->nama_ayah,
            "tanggal_lahir_ayah"  => $request->tanggal_lahir_ayah,
            "pendidikan_ayah"     => $request->pendidikan_ayah,
            "pekerjaan_ayah"      => $request->pekerjaan_ayah,
            "penghasilan_ayah"    => $request->penghasilan_ayah,
            "nik_ibu"             => $request->nik_ibu,
            "status_ibu"          => $request->status_ibu,
            "nama_ibu"            => $request->nama_ibu,
            "tanggal_lahir_ibu"   => $request->tanggal_lahir_ibu,
            "pendidikan_ibu"      => $request->pendidikan_ibu,
            "pekerjaan_ibu"       => $request->pekerjaan_ibu,
            "penghasilan_ibu"     => $request->penghasilan_ibu
        ]);

        // Update Data Atribut
        $atribut = Atribut::where('pendaftar_id', $id)->update([
            'atribut_kaos' => $request->atribut_kaos,
            'atribut_topi' => $request->atribut_topi,
            'atribut_almamater' => $request->atribut_almamater,
            'atribut_jas_lab' => $request->atribut_jas_lab,
            'atribut_baju_lapangan' => $request->atribut_baju_lapangan,
        ]);

        if (!empty($request->file)) {
            foreach ($request->file as $key => $value) {
                $nama =  $id . '.' . $value->extension();
                $value->move(public_path('assets/file/' . $key . '/'), $nama);
            }
        }

        return redirect(route('kelengkapan-data.edit', $id));
    }

    public function region($id)
    {
        try {
            $provinsi = RefRegion::find($id);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }

        return response()->json($provinsi->children);
    }
}
