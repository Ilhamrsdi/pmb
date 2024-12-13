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
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\BniEnc;
use App\Models\RefPorgramStudi;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validate = Validator::make($data, [
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
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

        $detailPendaftar = DetailPendaftar::create([
            'pendaftar_id' => $pendaftar->id,
            'kode_bayar' => $password,
            'tanggal_daftar' => now(),
            'va_pendaftaran' => rand(10000000000, 9999999999),
            'trx_va' => rand(10000000000, 9999999999),
            'datetime_expired' => 'date_expired',
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
            'password' => $detailPendaftar->kode_bayar,
            'gelombang' => $gelombang->nama_gelombang . " - " . $gelombang->deskripsi,
            'program_studi' => $program_studi->nama_program_studi
        ];

        Mail::to($user->email)->send(new EmailNotification($mailData));

        return $user;
    }

    public function userIsNotNull($user, array $data)
{
    // Cek apakah data pendaftar sudah ada
    $cek_pendaftar = Pendaftar::where('user_id', $user->id)
                               ->where('gelombang_id', $data['gelombang'])
                               ->first();

    if ($cek_pendaftar != null) {
        return redirect('landing'); // Jika sudah ada pendaftar, redirect
    } else {
        // Ambil data pendaftar dengan detailPendaftar
        $data_pendaftar = Pendaftar::where('user_id', $user->id)
                                   ->with('detailPendaftar') // Pastikan relasi detailPendaftar dimuat
                                   ->first();

        // Debugging: Cek apakah data_pendaftar ada dan cek relasi detailPendaftar
        // \Log::debug('Data Pendaftar:', ['data_pendaftar' => $data_pendaftar]);

        if ($data_pendaftar) {
            // Debugging: Cek apakah detailPendaftar berisi data
            if ($data_pendaftar->detailPendaftar->isEmpty()) {
                // \Log::debug('Detail Pendaftar kosong');
                // Jika detailPendaftar kosong, beri kode bayar baru
                $kode_bayar = rand(100000, 999999);
            } else {
                // \Log::debug('Detail Pendaftar ditemukan:', ['detail_pendaftar' => $data_pendaftar->detailPendaftar]);
                // Ambil kode_bayar dari data yang ada
                $kode_bayar = $data_pendaftar->detailPendaftar->first()->kode_bayar;
            }

            // Proses lanjutkan dengan data pendaftar baru
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
                'kode_bayar' => $kode_bayar,
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
                'body' => 'Silahkan mengikuti tata cara pendaftaran dan masuk kedalam aplikasi. Mohon menjaga privasi akun masing-masing',
                'email' => $user->email,
                'password' => $detailPendaftar->kode_bayar,
                'gelombang' => $gelombang->nama_gelombang . " - " . $gelombang->deskripsi,
                'program_studi' => $program_studi->nama_program_studi
            ];

            // Kirim email pemberitahuan
            Mail::to($user->email)->send(new EmailNotification($mailData));
        } else {
            // Jika tidak ada data pendaftar, beri pesan error
            // \Log::debug('Pendaftar tidak ditemukan');
            return response()->json(['error' => 'Data pendaftar tidak ditemukan'], 404);
        }
    }
}

    

    // public function createVA(array $data)
    // {
    //     // FROM BNI
    //     $biaya_pendataran = GelombangPendaftaran::where('id', $data['gelombang'])->first();
    
    //     $client_id = '21016';
    //     $secret_key = '6094ecb0bcb62da963f1b50a876ffe02';
    //     $url = 'https://apibeta.bni-ecollection.com/';
    
    //     $data_asli = [
    //         'client_id' => $client_id,
    //         'trx_id' => mt_rand(),
    //         'trx_amount' => $biaya_pendataran->nominal_pendaftaran,
    //         'billing_type' => 'c',
    //         'type' => 'createbilling',
    //         'datetime_expired' => date('c', time() + 24 * 3600),
    //         'virtual_account' => '',
    //         'customer_name' => $data['nama'],
    //         'customer_email' => '',
    //         'customer_phone' => '',
    //     ];
    
    //     $hashed_string = BniEnc::encrypt($data_asli, $client_id, $secret_key);
    
    //     $response = Http::post($url, ['client_id' => $client_id, 'data' => $hashed_string]);
    //     $response_json = json_decode($response, true);
    
    //     if ($response_json['status'] !== '000') {
    //         // Menangani error jika status bukan '000'
    //         return ['error' => 'Failed to create virtual account.'];
    //     }
    
    //     // Pastikan untuk memeriksa apakah key 'virtual_account' ada sebelum mengaksesnya
    //     if (isset($response_json['data']['virtual_account'])) {
    //         return $response_json['data'];
    //     }
    
    //     // Jika key 'virtual_account' tidak ditemukan, kembalikan error atau nilai default
    //     return ['error' => 'Virtual account not found.'];
    // }

    // public function CekPendaftaranVA(array $data)
    // {
    //     $va_bni = $this->createVA($data);
    
    //     // Periksa apakah terjadi error saat pembuatan VA
    //     if (isset($va_bni['error'])) {
    //         // Tangani error jika tidak ada data VA
    //         return $va_bni;  // Mengembalikan error yang sudah ada
    //     }
    
    //     $client_id = '21016';
    //     $secret_key = '6094ecb0bcb62da963f1b50a876ffe02';
    //     $url = 'https://apibeta.bni-ecollection.com/';
    
    //     $data_asli = [
    //         'client_id' => $client_id,
    //         'trx_id' => $va_bni['trx_id'], // Menggunakan trx_id dari VA yang sudah dibuat
    //         'trx_amount' => '',
    //         'type' => 'inquirybilling',
    //         'virtual_account' => $va_bni['virtual_account'], // Menggunakan virtual_account dari VA yang sudah dibuat
    //         'customer_name' => '',
    //         'customer_email' => '',
    //         'customer_phone' => '',
    //     ];
    
    //     $hashed_string = BniEnc::encrypt($data_asli, $client_id, $secret_key);
    
    //     $response = Http::post($url, ['client_id' => $client_id, 'data' => $hashed_string]);
    //     $response_json = json_decode($response, true);
    
    //     if ($response_json['status'] !== '000') {
    //         return ['error' => 'Failed to check payment status.'];
    //     }
    
    //     return BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
    // }
}
