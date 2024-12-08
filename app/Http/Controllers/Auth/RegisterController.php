<?php
// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Wali;
use App\Models\Atribut;
use App\Models\Pendaftar;
use App\Models\ProgramStudi;
use App\Mail\EmailNotification;
use App\Models\DetailPendaftar;
use App\Http\Controllers\Controller;
use App\Models\BniEnc;
use App\Models\GelombangPendaftaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\RefPorgramStudi;
use App\Services\BNIService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    protected $bniService;

    public function __construct(BNIService $bniService)
    {
        $this->middleware('guest');
        $this->bniService = $bniService;
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
            return $this->userIsNotNull($user, $data);
        } else {
            return $this->userIsNull($data);
        }
    }

    public function userIsNull(array $data)
    {
        // dd($data);

        // $this->createVA($va, $trx_id);
        $va_bni = $this->createVA($data);
        $cek_pendaftar_va_bni = $this->CekPendaftaranVA($data);
        // dd($cek_pendaftar_va_bni['datetime_expired']);
        $password = rand(100000, 999999);
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
            'va_pendaftaran' => $va_bni['virtual_account'],
            'trx_va' => $va_bni['trx_id'],
            'datetime_expired' => $cek_pendaftar_va_bni['datetime_expired'],
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
        \Log::debug('Data Pendaftar:', ['data_pendaftar' => $data_pendaftar]);

        if ($data_pendaftar) {
            // Debugging: Cek apakah detailPendaftar berisi data
            if ($data_pendaftar->detailPendaftar->isEmpty()) {
                \Log::debug('Detail Pendaftar kosong');
                // Jika detailPendaftar kosong, beri kode bayar baru
                $kode_bayar = rand(100000, 999999);
            } else {
                \Log::debug('Detail Pendaftar ditemukan:', ['detail_pendaftar' => $data_pendaftar->detailPendaftar]);
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
            \Log::debug('Pendaftar tidak ditemukan');
            return response()->json(['error' => 'Data pendaftar tidak ditemukan'], 404);
        }
    }
}
    public function createVA(array $data)
    {
        // Ambil biaya pendaftaran dari tabel GelombangPendaftaran
        $biaya_pendaftaran = GelombangPendaftaran::where('id', $data['gelombang'])->first();
    
        if (!$biaya_pendaftaran) {
            return ['error' => 'Gelombang pendaftaran tidak ditemukan.'];
        }
    
        $client_id = '21016';
        $secret_key = '6094ecb0bcb62da963f1b50a876ffe02';
        $url = 'https://apibeta.bni-ecollection.com/';
    
        $data_asli = [
            'client_id' => $client_id,
            'trx_id' => mt_rand(),
            'trx_amount' => $biaya_pendaftaran->nominal_pendaftaran,
            'billing_type' => 'c',
            'type' => 'createbilling',
            'datetime_expired' => date('c', time() + 24 * 3600),
            'virtual_account' => '',
            'customer_name' => $data['nama'],
            'customer_email' => '',
            'customer_phone' => '',
        ];
    
        try {
            $hashed_string = BniEnc::encrypt($data_asli, $client_id, $secret_key);
            $response = Http::post($url, ['client_id' => $client_id, 'data' => $hashed_string]);
            $response_json = json_decode($response, true);
    
            // Log response untuk debugging
            \Log::info('createVA Response', ['response' => $response_json]);
    
            if ($response_json['status'] !== '000') {
                return ['error' => $response_json['message'] ?? 'Failed to create virtual account.'];
            }
    
            if (isset($response_json['data']['virtual_account'])) {
                return $response_json['data'];
            }
    
            return ['error' => 'Virtual account tidak ditemukan dalam respons API.'];
        } catch (\Exception $e) {
            \Log::error('createVA Exception', ['exception' => $e->getMessage()]);
            return ['error' => $e->getMessage()];
        }
    }
    
    public function CekPendaftaranVA(array $data)
    {
        $va_bni = $this->createVA($data);
    
        // Log jika error ada
        if (isset($va_bni['error'])) {
            \Log::error('CekPendaftaranVA Error', ['error' => $va_bni['error']]);
            return $va_bni;
        }
    
        $client_id = '21016';
        $secret_key = '6094ecb0bcb62da963f1b50a876ffe02';
        $url = 'https://apibeta.bni-ecollection.com/';
    
        $data_asli = [
            'client_id' => $client_id,
            'trx_id' => $va_bni['trx_id'] ?? '',
            'trx_amount' => '',
            'type' => 'inquirybilling',
            'virtual_account' => $va_bni['virtual_account'] ?? '',
            'customer_name' => '',
            'customer_email' => '',
            'customer_phone' => '',
        ];
    
        try {
            $hashed_string = BniEnc::encrypt($data_asli, $client_id, $secret_key);
            $response = Http::post($url, ['client_id' => $client_id, 'data' => $hashed_string]);
            $response_json = json_decode($response, true);
    
            \Log::info('CekPendaftaranVA Response', ['response' => $response_json]);
    
            if ($response_json['status'] !== '000') {
                return ['error' => 'Gagal memeriksa status pembayaran.'];
            }
    
            return BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
        } catch (\Exception $e) {
            \Log::error('CekPendaftaranVA Exception', ['exception' => $e->getMessage()]);
            return ['error' => $e->getMessage()];
        }
    }
    
    
}
