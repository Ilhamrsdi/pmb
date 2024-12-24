<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Wali;
use App\Models\Atribut;
use App\Models\Pendaftar;
use App\Models\ProgramStudi;
use App\Mail\EmailNotification;
use App\Models\DetailPendaftar;
use App\Http\Controllers\Controller;
use App\Models\GelombangPendaftaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\RefPorgramStudi;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Configuration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:16'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'avatar' => ['image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'sekolah' => ['required', 'string'],
            'program_studi' => ['required', 'string'],
            'gelombang' => ['required', 'integer'],
        ]);
        
        return $validate;
    }

    protected function create(array $data)
    {
        if (request()->has('avatar')) {
            $avatar = request()->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
        }

        $user = User::where('nik', $data['nik'])->first();

        if ($user != NULL) {
            $this->userIsNotNull($user, $data);
        } else {
            $user = $this->userIsNull($data);
        }

        session(['gelombang_id' => $data['gelombang']]);

        return $user;
    }

    public function userIsNull(array $data)
    {
        // dd($data);

        // $this->createVA($va, $trx_id);
        // $va_bni = $this->createVA($data);
        // $cek_pendaftar_va_bni = $this->CekPendaftaranVA($data);
        // dd($cek_pendaftar_va_bni['datetime_expired']);
        $trx_va_ukt = Str::random(5);
        $trx_va = Str::random(5);
        $password = 'password';
        $user = User::create([
            'username' => $data['nama'],
            'email' => $data['email'],
            'nik' => $data['nik'],
            'password' => Hash::make($password),
            'avatar' =>   'avatar-1.jpg',
        ]);


        $pendaftar = Pendaftar::create([
            'user_id' => $user->id,
            'nama' => $data['nama'],
            'sekolah' => $data['sekolah'],
            'program_studi_id' => $data['program_studi'],
            'prodi_lain_id' => $data['prodi_lain'],
            'gelombang_id' => $data['gelombang'],
        ]);

        $detailPendaftar = DetailPendaftar::create([
            'pendaftar_id' => $pendaftar->id,
            'kode_bayar' => random_int(100000, 999999), // Menghasilkan angka acak 6 digit
            'kode_pendaftaran' => random_int(100000, 999999), // Menghasilkan angka acak 6
            'tanggal_daftar' => now(),
            'va_pendaftaran' => random_int(100000, 999999999),
            'trx_va' => $trx_va,
            'trx_va_ukt' => $trx_va_ukt,
            'va_ukt' => random_int(100000000,9999999999),
            // 'trx_va' => $va_bni['trx_id'],
            // 'datetime_expired' => $cek_pendaftar_va_bni['datetime_expired'],
        ]);

        $wali = Wali::create([
            'pendaftar_id' => $pendaftar->id
        ]);

        $atribut = Atribut::create([
            'pendaftar_id' => $pendaftar->id
        ]);

        $program_studi = RefPorgramStudi::find($pendaftar->program_studi_id);
        $gelombang = GelombangPendaftaran::find($pendaftar->gelombang_id);

        $mailData = [
            'title' => 'Mail from PMB Poliwangi',
            'body' => 'Silahkan mengikuti tata cara pendaftaran dan masuk kedalam aplikasi. Mohon menjaga privasi akun masing masing',
            'email' => $user->email,
            'password' => 'password',
            'gelombang' => $gelombang->nama_gelombang . " - " . $gelombang->deskripsi,
            'program_studi' => $program_studi->name ,
            'prodi_lain' => $program_studi->prodi_lain->name ,
            
        ];

        Mail::to($user->email)->send(new EmailNotification($mailData));

        return $user;
    }
    

  
    public function userIsNotNull($user, array $data)
    {
        $cek_pendaftar = Pendaftar::where('user_id', $user->id)->where('gelombang_id', $data['gelombang'])->first();

        if ($cek_pendaftar != null) {
            redirect('landing');
        } else {
            $data_pendaftar = Pendaftar::where('user_id', $user->id)->with('detailPendaftar')->get();
            // dd($data_pendaftar);
            $pendaftar = Pendaftar::create([
                'user_id' => $user->id,
                'nama' => $data['nama'],
                'sekolah' => $data['sekolah'],
                'program_studi_id' => $data['program_studi'],
                'gelombang_id' => $data['gelombang'],
            ]);

            $detailPendaftar = DetailPendaftar::create([
                'pendaftar_id' => $pendaftar->id,
                'tanggal_daftar' => now(),
                'kode_bayar' => $data_pendaftar[0]->detailPendaftar->kode_bayar,
                'kode_pendaftaran' => $data_pendaftar[0]->detailPendaftar->kode_pendaftaran
                
            ]);

            $wali = Wali::create([
                'pendaftar_id' => $pendaftar->id
            ]);

            $atribut = Atribut::create([
                'pendaftar_id' => $pendaftar->id
            ]);

            $program_studi = RefPorgramStudi::find($pendaftar->program_studi_id);
            $gelombang = GelombangPendaftaran::find($pendaftar->gelombang_id);

            $mailData = [
                'title' => 'Mail from PMB Poliwangi',
                'body' => 'Silahkan mengikuti tata cara pendaftaran dan masuk kedalam aplikasi. Mohon menjaga privasi akun masing masing',
                'email' => $user->email,
                'password' => $detailPendaftar->password,
                'gelombang' => $gelombang->nama_gelombang . " - " . $gelombang->deskripsi,
                'program_studi' => $program_studi->nama_program_studi
            ];

            Mail::to($user->email)->send(new EmailNotification($mailData));
        }
    }

    // Membuat Invoice Xendit
    // public function createInvoice(array $data)
    // {
    //     Configuration::setXenditKey("xnd_public_development_kGtMW2a_VlZ43I0Xn0o3kCZ7EEOAT57fpWO8XWwMVVRPhfpVDboTYyrfoEVTtML");

    //     $biaya_pendaftaran = GelombangPendaftaran::where('id', $data['gelombang'])->first();
    //     $apiInstance = new InvoiceApi();
    //     $createInvoiceRequest = new CreateInvoiceRequest([
    //         'external_id' => 'inv-' . time(), // External ID yang unik
    //         'amount' => $biaya_pendaftaran->nominal_pendaftaran, // Nominal pendaftaran dari gelombang
    //         'payer_email' => $data['email'],
    //         'description' => 'Pembayaran pendaftaran ' . $data['nama'],
    //         'invoice_duration' => 86400 * 2, // Durasi invoice 2 hari
    //         'currency' => 'IDR',
    //     ]);

    //     try {
    //         // Buat invoice
    //         $result = $apiInstance->createInvoice($createInvoiceRequest);
    //         return $result; // Kembalikan hasil invoice
    //     } catch (\Xendit\XenditSdkException $e) {
    //         return null;
    //     }
    // }

    // Endpoint callback Xendit untuk update status pendaftaran
    // public function xenditCallback(Request $request)
    // {
    //     // Ambil data dari callback
    //     $data = $request->all();

    //     if ($data['status'] === 'PAID') {
    //         // Update status_pendaftaran menjadi 'disetujui' jika pembayaran sukses
    //         $detailPendaftar = DetailPendaftar::where('trx_va', $data['external_id'])->first();

    //         if ($detailPendaftar) {
    //             $pendaftar = Pendaftar::find($detailPendaftar->pendaftar_id);
    //             $pendaftar->update(['status_pendaftaran' => 'disetujui']);
    //         }
    //     }
    // }
}