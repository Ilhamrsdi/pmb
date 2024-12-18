<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Pendaftar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Global Controller
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
// Admin Controller
use App\Http\Controllers\Pendaftar\BuktiController;
use App\Http\Controllers\Admin\Prodi\ProdiController;
use App\Http\Controllers\Admin\Jurusan\JurusanController;
use App\Http\Controllers\Admin\Laporan\LaporanController;
use App\Http\Controllers\Admin\Pendaftar\ExcelController;
use App\Http\Controllers\Pendaftar\BiodataDiriController;
use App\Http\Controllers\Admin\Golongan_UKT\UKTController;
use App\Http\Controllers\Admin\Pendaftar\MabaUKTController;
use App\Http\Controllers\Admin\Pendaftar\TesMabaController;
use App\Http\Controllers\Admin\Gelombang\GelombangController;
use App\Http\Controllers\Admin\Pendaftar\CamabaAccController;
use App\Http\Controllers\Admin\Pendaftar\PendaftarController;
use App\Http\Controllers\Admin\Transaksi\TransaksiController;
use App\Http\Controllers\Pendaftar\BerkasPendukungController;
use App\Http\Controllers\Pendaftar\BiodataOrangTuaController;
use App\Http\Controllers\Admin\Berkas\SettingBerkasController;
use App\Http\Controllers\Admin\Pendaftar\SoalTesMabaController;
use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\Admin\Alur\AlurPendaftaranController;
use App\Http\Controllers\PdfController;


// Pendaftar Controller
use App\Http\Controllers\Admin\Pengumuman\PengumumanController;
use App\Http\Controllers\Admin\Pendaftar\MabaAttributController;
use App\Http\Controllers\Admin\Golongan_UKT\GolonganUKTController;
use App\Http\Controllers\Admin\Golongan_UKT\PendaftarUKTController;
use App\Http\Controllers\Admin\Pendaftar\CamabaSdhBlmUKTController;
use App\Http\Controllers\Admin\PesanSiaran\PesanSiaranController;
use App\Http\Controllers\Pendaftar\KelengkapanDataController;

// Import UserController
use App\Http\Controllers\UserController;
// GenerateNim Controller
use App\Http\Controllers\GenerateNimController;
use App\Http\Controllers\Panitia\PanitiaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/cek_va_ukt', [DashboardController::class, 'CekUKT']);
Route::get('/', [App\Http\Controllers\LandingController::class, 'index']);
Route::get('/pengumuman/{id}', [App\Http\Controllers\LandingController::class, 'pengumuman']);
Route::post('/cekkode', [App\Http\Controllers\LandingController::class, 'cekkode']);
Route::get('/cektemplate', function () {
    return view('ui-cards');
});

Auth::routes([]);

// Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::group(['prefix' => 'error'], function () {
    Route::get('404', function () {
        return view('error.404');
    })->name('error-404');
    Route::get('500', function () {
        return view('error.500');
    })->name('error-500');
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "App optimized";
});

// Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware([Admin::class, 'auth'])->prefix('admin')->group(function () {
    // Pendaftar
    Route::resource('pendaftar', PendaftarController::class);
    Route::get('/access-logs', [AccessLogController::class, 'index'])->name('access-logs.index');
    Route::delete('/access-logs/{id}', [AccessLogController::class, 'destroy'])->name('access-logs.destroy');
    Route::post('/access-logs/delete-all', [AccessLogController::class, 'deleteAll'])->name('access-logs.delete-all');
    
    // Route untuk update status pendaftaran
    Route::post('/pendaftar/update-status', [PendaftarController::class, 'updateStatus'])->name('pendaftar.update-status');
    // Route untuk update status pembayaran
    Route::post('/camaba-ukt/update-status', [CamabaSdhBlmUKTController::class, 'updateStatus'])->name('camaba-ukt.update-status');

    Route::post('pendaftar-excel', [ExcelController::class, 'import'])->name('import.pendaftar');
    Route::post('ukt-excel', [ExcelController::class, 'import_ukt'])->name('import.ukt');
    Route::get('camaba/export-excel', [ExcelController::class, 'exportToExcel'])->name('camaba.export-excel');
    Route::resource('camaba-acc', CamabaAccController::class);
    Route::resource('camaba-ukt', CamabaSdhBlmUKTController::class);
    Route::resource('maba-ukt', MabaUKTController::class);
    Route::resource('tes-maba', TesMabaController::class);
    Route::resource('pengumuman', PengumumanController::class);

    Route::get('/soal-tes-maba/{id}', [SoalTesMabaController::class, 'show'])->name('soal-tes-maba.show');
    Route::post('/soal-tes-maba-add', [SoalTesMabaController::class, 'store'])->name('soal-tes-maba-add.store');

    Route::get('/maba-attribut', [MabaAttributController::class, 'index'])->name('maba-attribut.index');
    Route::get('/maba-attribut-pdf/{id}', [MabaAttributController::class, 'pdf'])->name('maba-attribut.pdf');
    Route::post('/maba-attribut-kaos/{id}', [MabaAttributController::class, 'updateKaos'])->name('maba-attribut.kaos');
    Route::post('/maba-attribut-topi/{id}', [MabaAttributController::class, 'updateTopi'])->name('maba-attribut.topi');
    Route::post('/maba-attribut-almamater/{id}', [MabaAttributController::class, 'updateAlmamater'])->name('maba-attribut.almamater');
    Route::post('/maba-attribut-jas/{id}', [MabaAttributController::class, 'updateJasLab'])->name('maba-attribut.jas');
    Route::post('/maba-attribut-baju-lapangan/{id}', [MabaAttributController::class, 'updateBajuLapangan'])->name('maba-attribut.baju-lapangan');

    Route::resource('gelombang', GelombangController::class);
    Route::post('transaksi_berkas_gelombang', [TransaksiController::class, 'BerkasGelombang'])->name('transaksis.berkas_gelombang');

    Route::resource('jurusan', JurusanController::class);
    Route::get('sync/jurusan', [JurusanController::class, 'sync'])->name('jurusan.sync');
    Route::resource('prodi', ProdiController::class);
    Route::get('sync/prodi', [ProdiController::class, 'sync'])->name('prodi.sync');
    Route::resource('settingberkas', SettingBerkasController::class);

    // Golongan & UKT
    Route::resource('golongan-ukt', GolonganUKTController::class);
    Route::resource('ukt', UKTController::class);
    Route::get('listPendaftar/{id}', [PendaftarUKTController::class, 'listPendaftar'])->name('listPendaftar.ukt');
    Route::post('pendaftarCreateUKT', [PendaftarUKTController::class, 'pendaftarCreateUKT'])->name('pendaftarCreateUKT.ukt');
    Route::post('pendaftarDeleteUKT/', [PendaftarUKTController::class, 'pendaftarDeleteUKT'])->name('pendaftarDeleteUKT.ukt');

    // Laporan
    Route::get('laporan/laporan-penerimaan', [LaporanController::class, 'laporan_penerimaan'])->name('laporanPenerimaan');
    Route::get('laporan/laporan-pembayaran', [LaporanController::class, 'laporan_pembayaran'])->name('laporanPembayaran');
    Route::get('laporan/grafik-provinsi', [LaporanController::class, 'grafik_provinsi'])->name('grafikProvinsi');
    Route::get('laporan/grafik-prodi', [LaporanController::class, 'grafik_prodi'])->name('grafikProdi');

    // Alur Pendaftaran
    Route::get('lainnya/alur-pendaftaran', [AlurPendaftaranController::class, 'index'])->name('alurPendaftaran');
    Route::get('lainnya/alur-pendaftaran/create', [AlurPendaftaranController::class, 'create'])->name('alurPendaftaran.create');
    Route::post('lainnya/alur-pendaftaran', [AlurPendaftaranController::class, 'store'])->name('alurPendaftaran.store');
    Route::get('lainnya/alur-pendaftaran/{id}', [AlurPendaftaranController::class, 'show'])->name('alurPendaftaran.show');
    Route::get('lainnya/alur-pendaftaran/{id}/edit', [AlurPendaftaranController::class, 'edit'])->name('alurPendaftaran.edit');
    Route::put('lainnya/alur-pendaftaran/{id}', [AlurPendaftaranController::class, 'update'])->name('alurPendaftaran.update');
    Route::delete('lainnya/alur-pendaftaran/{id}', [AlurPendaftaranController::class, 'destroy'])->name('alurPendaftaran.destroy');
    // Pesan Siaran
    Route::get('pesan-siaran', [PesanSiaranController::class, 'index'])->name('pesanSiaran');
    Route::post('pesan-siaran/kirim', [PesanSiaranController::class, 'kirimPesan'])->name('admin.pesan-siaran.kirim');

    // User Management
    Route::resource('users', UserController::class); // Add this line

    // Menampilkan daftar pendaftar dan melakukan generate NIM massal
    Route::get('/generate-nim', [GenerateNimController::class, 'index'])->name('generate-nim.index');
    Route::post('/generate-nim-massal', [GenerateNimController::class, 'generateNIMMassal'])->name('generate-nim.massal');
});

// Route untuk halaman edit pendaftar
Route::middleware([Pendaftar::class, 'auth'])->prefix('pendaftar')->group(function () {
    Route::post('upload/bukti-bayar-pendaftaran', [BuktiController::class, 'upload_bukti_pendaftaran'])->name('upload-bukti-pendaftaran');
    Route::get('/ujian/{id}', [SoalTesMabaController::class, 'index'])->name('pendaftar.ujian.index');
    Route::post('/store-answers', [SoalTesMabaController::class, 'storeAnswers'])->name('storeAnswers');
    Route::post('ujian/result', [SoalTesMabaController::class, 'result'])->name('pendaftar.ujian.result');
    Route::post('upload/bukti-bayar-ukt', [BuktiController::class, 'upload_bukti_ukt'])->name('upload-bukti-ukt');
    
    // Route untuk kelengkapan data pendaftar
    Route::get('kelengkapan-data/{id}', [KelengkapanDataController::class, 'edit'])->name('kelengkapan-data.edit');
    Route::put('kelengkapan-data/{id}', [KelengkapanDataController::class, 'update'])->name('kelengkapan-data.update');
    
    Route::get('bukti/{id}', [BuktiController::class, 'show'])->name('bukti.show');
    Route::get('/generate-pdf', [PdfController::class, 'generatePDF'])->name('generate-pdf');

});

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::post('/xendit/callback', [RegisterController::class, 'xenditCallback']);
