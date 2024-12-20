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
use App\Models\RefJenis_tinggal;
use App\Http\Controllers\Controller;
use App\Models\AtributGambar;
use App\Models\BerkasGelombangTransaksi;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File; // Tambahkan ini
use GuzzleHttp\Client;

class KelengkapanDataController extends Controller
{


    public function edit($id)
{
    // Inisialisasi client untuk request API
    $client = new Client();
    
    // Mengambil data provinsi dari API Fariz

    $authToken = 'Bearer ' . '862|YCzEMXYliDUTt02b8sgvLDjmf5ZHIvDoAJiTBQto';
    $responseProvinsi = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/provinces', [
        'headers' => [
            'Authorization' => $authToken,
        ],
    ]);
    $provinsi = json_decode($responseProvinsi->getBody(), true)['data']; // Ambil array 'provinsi'


    $responseKendaraan = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/transportations', [
        'headers' => [
            'Authorization' => $authToken,
        ],
    ]);
    $kendaraan = json_decode($responseKendaraan->getBody(), true)['data'];
    // return $kendaraan;
    // Mengambil data pendaftar dari database
    $pendaftar = Pendaftar::where('id', $id)->with('user', 'atribut')->first();

    // Form Biodata Diri
    // $kendaraan = RefKendaraan::get();
    // $jenis_tinggal = RefJenis_tinggal::get();
    $responseJenis_tinggal = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/type-of-stays', [
        'headers' => [
            'Authorization' => $authToken,
        ],
    ]);
    $jenis_tinggal = json_decode($responseJenis_tinggal->getBody(), true)['data'];
    // $negara = RefCountry::orderBy('name')->get();
    $responseNegara = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/countries', [
        'headers' => [
            'Authorization' => $authToken,
        ],
    ]);
    $negara = json_decode($responseNegara->getBody(), true)['data'];
    
    // Mengambil data kabupaten berdasarkan provinsi pendaftar (jika ada)
  
    // $responsekabupaten_kota = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/cities', [
    //     'headers' => [
    //         'Authorization' => $authToken,
    //     ],
    // ]);
    // $kabupaten_kota = json_decode($responsekabupaten_kota->getBody(), true)['data']; // Ambil array 'provinsi'
  // Mengambil data kabupaten/kota dari API
  $responsekabupaten_kota = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/cities', [
    'headers' => [
        'Authorization' => $authToken,
    ],
]);

// Mengdecode body respons menjadi array asosiatif
$kabupaten_kota = json_decode($responsekabupaten_kota->getBody(), true);

// Memeriksa apakah respons berhasil dan terdapat data kabupaten/kota
$kabupatenKotaData = isset($kabupaten_kota['data']) ? $kabupaten_kota['data'] : [];

// $kecamatan = RefRegion::where('level', 3)->get();

$responsekecamatan = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/sub-districts', [
    'headers' => [
        'Authorization' => $authToken,
    ],
]);
$kecamatan = json_decode($responsekecamatan->getBody(), true)['data'];
    

    // Ambil data kecamatan dan lainnya

    // $agama = RefAgama::get();
    $responseAgama = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/religions', [
        'headers' => [
            'Authorization' => $authToken,
        ],
    ]);
    $agama = json_decode($responseAgama->getBody(), true)['data'];
    $ukuran = ['s', 'm', 'l', 'xl', 'xxl'];

    // Form Biodata Orang Tua
    // $pendidikan = RefPendidikan::get();
    $responsePendidikan = $client->get('http://backend.sepyankristanto.my.id/api/v1/master/religions', [
        'headers' => [
            'Authorization' => $authToken,
        ],
    ]);
    $pendidikan = json_decode($responsePendidikan->getBody(), true)['data'];
    $profesi = RefProfesi::get();
    $pendapatan = RefPendapatan::get();

    // Form Berkas Pendukung
    $list_berkas = BerkasGelombangTransaksi::where('gelombang_id', $pendaftar->gelombang_id)
        ->with('berkas') // Eager load relasi settingBerkas
        ->get();
    $atributGambars = AtributGambar::all();

    // dd($atributGambars);
    // dd($list_berkas);    
    // Kirim data ke view
    return view('pendaftar.kelengkapan-data.kelengkapan-data', compact(
        'pendaftar', 'kendaraan', 'jenis_tinggal', 'negara', 'provinsi', 
        'kabupaten_kota', 'kecamatan', 'agama', 'ukuran', 
        'pendidikan', 'profesi', 'pendapatan', 'list_berkas', 'kabupatenKotaData', 'atributGambars'
    ));
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
            "jenis_kelamin"     => $request->jenis_kelamin,
            "kendaraan"         => $request->kendaraan,
            "kewarganegaraan"   => $request->kewarganegaraan,
            "negara"            => $request->negara,
            "provinsi"          => $request->provinsi ?? 'jatim',
            "kabupaten"         => $request->kabupaten ?? 'banyuwangi',
            "kecamatan"         => $request->kecamatan ?? 'banyuwangi',
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
        // return $request->all();

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
        // $namas = [];
     
        if (!empty($request->file)) {
            foreach ($request->file as $key => $value) {
                $nama =  $id . '.' . $value->extension();
                $value->move(public_path('assets/file/' . $key . '/'), $nama);
            }
        }

        return redirect(route('dashboard', $id));
    }

//   use Illuminate\Support\Facades\Http; // Pastikan ini di-import





}
