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
use Xendit\Xendit;
// use Xendit\VirtualAccounts;
use Xendit\PaymentRequest\VirtualAccount;
// use Xendit;
use Xendit\Exceptions\ApiException;
use Xendit\XenditSdkException;


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
            'gelombang_id' => $data['gelombang'],
        ]);
    
        // Buat Virtual Account setelah pendaftar dibuat
        $va = $this->createVA([
            'nama' => $data['nama'],
            'gelombang' => $data['gelombang']
        ]);
    
        if ($va) {
            $detailPendaftar = DetailPendaftar::create([
                'pendaftar_id' => $pendaftar->id,
                'kode_bayar' => random_int(100000, 999999), // Menghasilkan angka acak 6 digit
                'trx_va' => $va['external_id'], // External ID dari VA
                'va_pendaftaran' => $va['account_number'], // Nomor Virtual Account
                'bank' => $va['BNI'], // Kode Bank (misal BNI, BCA)
                'tanggal_daftar' => now(),
                'datetime_expired' => $va['expiration_date'] // Tanggal expired VA
            ]);
        } else {
            $detailPendaftar = DetailPendaftar::create([
                'pendaftar_id' => $pendaftar->id,
                'kode_bayar' => random_int(100000, 999999), // Menghasilkan angka acak 6 digit
                'tanggal_daftar' => now(),
            ]);
        }
    
        Wali::create([
            'pendaftar_id' => $pendaftar->id
        ]);
    
        Atribut::create([
            'pendaftar_id' => $pendaftar->id
        ]);
    
        $program_studi = RefPorgramStudi::find($pendaftar->program_studi_id);
        $gelombang = GelombangPendaftaran::find($pendaftar->gelombang_id);
    
        $mailData = [
            'title' => 'Mail from PMB Poliwangi',
            'body' => 'Silahkan mengikuti tata cara pendaftaran dan masuk kedalam aplikasi. Mohon menjaga privasi akun masing masing',
            'email' => $user->email,
            'nik' => $user->nik,
            'password' => $detailPendaftar->kode_bayar,
            'gelombang' => $gelombang->nama_gelombang . " - " . $gelombang->deskripsi,
            'program_studi' => $program_studi->nama_program_studi
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
                'kode_bayar' => $data_pendaftar[0]->detailPendaftar->kode_bayar
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
                'nik' => $user->nik,
                'password' => $detailPendaftar->kode_bayar,
                'gelombang' => $gelombang->nama_gelombang . " - " . $gelombang->deskripsi,
                'program_studi' => $program_studi->nama_program_studi
            ];

            Mail::to($user->email)->send(new EmailNotification($mailData));
        }
    }

    // Membuat Invoice Xendit
    public function createVA(array $data)
    {
        // API Key Xendit
        Xendit::setApiKey('xnd_public_development_kGtMW2a_VlZ43I0Xn0o3kCZ7EEOAT57fpWO8XWwMVVRPhfpVDboTYyrfoEVTtML');
    
        // Ambil data biaya pendaftaran dari GelombangPendaftaran
        $biaya_pendaftaran = GelombangPendaftaran::where('id', $data->gelombang)->first();
    
        // Params untuk membuat Virtual Account melalui Xendit (untuk pendaftaran)
        $params_pendaftaran = [
            'external_id' => 'va_pendaftaran_' . time(), // External ID unik untuk pendaftaran
            'bank_code' => 'BNI', // Bank yang didukung Xendit
            'name' => $data->nama_pendaftar, // Nama pendaftar
            'expected_amount' => $data->nominal_pendaftaran ?: $biaya_pendaftaran->nominal_pendaftaran, // Nominal pendaftaran
            'is_closed' => true, // VA akan dihapus setelah pembayaran sukses
            'expiration_date' => date('c', time() + 86400 * 2), // Expired setelah 2 hari
        ];
    
        try {
            // Buat Virtual Account untuk pendaftaran
            $result_pendaftaran = VirtualAccount::create($params_pendaftaran);
    
            // Simpan data VA pendaftaran ke dalam tabel detailPendaftars
            $detailPendaftar = DetailPendaftar::where('pendaftar_id', $data->pendaftar_id)->first(); // Cari data detail pendaftar terkait
            $detailPendaftar->va_pendaftaran = $result_pendaftaran['account_number']; // Nomor VA untuk pendaftaran
            $detailPendaftar->trx_va = $result_pendaftaran['external_id']; // External ID untuk pendaftaran
            $detailPendaftar->datetime_expired = $result_pendaftaran['expiration_date']; // Tanggal expired VA pendaftaran
            $detailPendaftar->nominal_ukt = $result_pendaftaran['expected_amount']; // Nominal pendaftaran
    
            // Simpan data ke tabel detailPendaftars
            $detailPendaftar->save();
    
            // Kembalikan hasil pembuatan Virtual Account
            return response()->json($detailPendaftar);
        } catch (XenditSdkException $e) {
            // Tangkap error dan kembalikan sebagai response error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    

    
    // Endpoint callback Xendit untuk update status pendaftaran
    public function xenditCallback(Request $request)
    {
        // Ambil data dari callback
        $data = $request->all();
    
        if ($data['status'] === 'SETTLED') {
            // Update status_pendaftaran menjadi 'disetujui' jika pembayaran sukses
            $detailPendaftar = DetailPendaftar::where('trx_va', $data['external_id'])->first();
    
            if ($detailPendaftar) {
                $pendaftar = Pendaftar::find($detailPendaftar->pendaftar_id);
                $pendaftar->update(['status_pendaftaran' => 'disetujui']);
                $program_studi = RefPorgramStudi::find($pendaftar->program_studi_id);
                $gelombang = GelombangPendaftaran::find($pendaftar->gelombang_id);
        
                $mailData = [
                    'title' => 'Mail from PMB Poliwangi',
                    'body' => 'Silahkan mengikuti tata cara pendaftaran dan masuk kedalam aplikasi. Mohon menjaga privasi akun masing masing',
                    'email' => $pendaftar->email,
                    'nik' => $pendaftar->nik,
                    'password' => $detailPendaftar->kode_bayar,
                    'gelombang' => $gelombang->nama_gelombang . " - " . $gelombang->deskripsi,
                    'program_studi' => $program_studi->nama_program_studi
                ];
                Mail::to($pendaftar->email)->send(new EmailNotification($mailData));
            }
        }
        
    }
    
}