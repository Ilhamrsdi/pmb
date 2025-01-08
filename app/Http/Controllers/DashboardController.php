<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\BniEnc;
use App\Models\TataCara;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use App\Models\DetailPendaftar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    // public function index(Request $request)
    // {
    //     if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3) {
    //         // Admin atau panitia
    //         $total_pendaftar = Pendaftar::count();
    //         $total_belum_bayar_pendaftaran = DetailPendaftar::whereNull('status_pendaftaran')->count();
    //         $total_belum_bayar_ukt = DetailPendaftar::where('status_pembayaran', 'belum')->count();
    //         $total_diterima = DetailPendaftar::where('status_acc', 'sudah')->count();
    //         $total_belum_diterima = DetailPendaftar::whereNull('status_acc')->count();
    
    //         $data = [
    //             'total_pendaftar' => $total_pendaftar,
    //             'total_belum_bayar_pendaftaran' => $total_belum_bayar_pendaftaran,
    //             'total_belum_bayar_ukt' => $total_belum_bayar_ukt,
    //             'total_diterima' => $total_diterima,
    //             'total_belum_diterima' => $total_belum_diterima,
    //         ];
    
    //         return view('admin.dashboard', compact('data'));
    //     } else {
    //         // Pendaftar
    //         $pendaftar = Pendaftar::where('user_id', auth()->user()->id)->get();
    //         $tata_cara = TataCara::where('jenis', '!=', 'pendaftaran')->get()->groupBy('jenis', 'ASC');
    
    //         $data = null;
    //         foreach ($pendaftar as $value) {
    //             if ($value->gelombang_id == session('gelombang_id')) {
    //                 $data = $value;
    //                 session(['pendaftar_id' => $data->id]);
    //                 break; // Keluar dari loop setelah menemukan data
    //             }
    //         }
    
    //         if ($data == null) {
    //             Session::flush();
    //             Auth::logout();
    
    //             return redirect('login')->with('error_gelombang', 'Anda tidak terdaftar di gelombang yang dipilih');
    //         } else {
    //             // Cek apakah detail pendaftar ada
    //             if ($data->detailPendaftar) {
    //                 // Cek status pendaftaran
    //                 if ($data->detailPendaftar->status_pendaftaran == null) {
    //                     // Belum mendaftar
    //                     $dataPendaftar = $data->detailPendaftar->pendaftar_id;
    //                     $nomer_va = $data->detailPendaftar->va_pendaftaran;
    //                     $expired_va = $data->detailPendaftar->datetime_expired;
    
    //                     return view('pendaftar.dashboard.dashboard-pendaftaran', compact('nomer_va', 'expired_va', 'tata_cara', 'dataPendaftar'));
    //                 } elseif ($data->detailPendaftar->status_pendaftaran == 'sudah') {
    //                     // Cek status acc
    //                     if ($data->detailPendaftar->status_acc == 'sudah') {
    //                         // Redirect ke halaman untuk melakukan ujian
    //                         return redirect()->route('ujian.index', $data->id);

    //                     } else {
    //                         // Redirect ke halaman untuk melengkapi biodata diri
    //                         return redirect()->route('kelengkapan-data.edit', $data->id);
    //                     }
    //                 }
    
    //                 // Cek status UKT
    //                 if ($data->detailPendaftar->nominal_ukt == null) {
    //                     return view('pendaftar.dashboard.dashboard-belum-ukt');
    //                 } elseif ($data->detailPendaftar->nominal_ukt != null && $data->detailPendaftar->status_pembayaran == null) {
    //                     $nomer_va = $data->detailPendaftar->va_ukt;
    //                     $expired_va = $data->detailPendaftar->datetime_expired_ukt;
    //                     $nominal_ukt = $data->detailPendaftar->nominal_ukt;
    //                     $id_pendaftar = $data->detailPendaftar->id;
    //                     $nama_pendaftar = $data->nama;
    //                     $dataPendaftar = $data->detailPendaftar->pendaftar_id;
    
    //                     return view('pendaftar.dashboard.dashboard-ukt', compact('nomer_va', 'expired_va', 'tata_cara', 'nominal_ukt', 'nama_pendaftar', 'id_pendaftar', 'dataPendaftar'));
    //                 } else {
    //                     return redirect(route('bukti.show', $data->id));
    //                 }
    //             } else {
    //                 // Jika detail pendaftar tidak ada
    //                 return redirect()->route('error.page'); // Ganti dengan rute error yang sesuai
    //             }
    //         }
    //     }
    // }
    // public function index(Request $request)
    // {
    //     if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3)  {

    //         $total_pendaftar = Pendaftar::count();
    //         $total_belum_bayar_pendaftaran = DetailPendaftar::whereNull('status_pendaftaran')->count();
    //         $total_belum_bayar_ukt = DetailPendaftar::whereNull('status_pembayaran')->count();
    //         $total_diterima = DetailPendaftar::where('status_acc', 'sudah')->count();
    //         $total_belum_diterima = DetailPendaftar::whereNull('status_acc')->count();

    //         $data = [
    //             'total_pendaftar' => $total_pendaftar,
    //             'total_belum_bayar_pendaftaran' => $total_belum_bayar_pendaftaran,
    //             'total_belum_bayar_ukt' => $total_belum_bayar_ukt,
    //             'total_diterima' => $total_diterima,
    //             'total_belum_diterima' => $total_belum_diterima
    //         ];

    //         return view('admin.dashboard', compact('data'));
    //     } else {
    //         $pendaftar = Pendaftar::where('user_id', auth()->user()->id)->get();
    //         $tata_cara = TataCara::where('jenis', '!=', 'pendaftaran')->get()->groupBy('jenis', 'ASC');

    //         // dd($tata_cara);
    //         $data = null;
    //         foreach ($pendaftar as $key => $value) {
    //             if ($value->gelombang_id == session('gelombang_id')) {
    //                 $data = $value;
    //                 session(['pendaftar_id' => $data->id]);
    //             }
    //         }

    //         if ($data == null) {
    //             Session::flush();
    //             Auth::logout();

    //             return redirect('login')->with('error_gelombang', 'Anda tidak terdaftar di gelombang yang dipilih');
    //         } else {

    //             // dd($data);
    //             if ($data->detailPendaftar->status_pendaftaran == NULL) {
    //                 $dataPendaftar = $data->detailPendaftar->pendaftar_id;
    //                 //  dd($dataPendaftar);

    //                 /**
    //                  * TODO 'Masih ada BUG'
    //                  */
    //                 // $cek_pembayaran_bni = $this->CekPembayaranVAPendaftaran($request);
    //                 // // dd($cek_pembayaran_bni);
    //                 // if ($cek_pembayaran_bni['payment_amount'] == $cek_pembayaran_bni['trx_amount']) {
    //                 //     $StatusPembayaran =  DetailPendaftar::where('pendaftar_id', $dataPendaftar)->update([
    //                 //         'status_pendaftaran' => 'sudah',
    //                 //     ]);
    //                 // }

    //                 // dd($StatusPembayaran);
    //                 //   $cek_pembayaran_bni['payment_amount']
    //                 // $cek_pembayaran_bni['trx_amount']
    //                 $nomer_va = $data->detailPendaftar->va_pendaftaran;
    //                 $expired_va = $data->detailPendaftar->datetime_expired;
    //                 return view('pendaftar.dashboard.dashboard-pendaftaran', compact('nomer_va', 'expired_va', 'tata_cara'));
    //             } else {
    //                 if ($data->detailPendaftar->nominal_ukt == NULL) {
    //                     return view('pendaftar.dashboard.dashboard-belum-ukt');
    //                 } elseif (
    //                     $data->detailPendaftar->nominal_ukt != NULL &&
    //                     $data->detailPendaftar->status_pembayaran == NULL
    //                 ) {
    //                     $nomer_va = $data->detailPendaftar->va_ukt;
    //                     $expired_va = $data->detailPendaftar->datetime_expired_ukt;
    //                     $nominal_ukt = $data->detailPendaftar->nominal_ukt;
    //                     $id_pendaftar = $data->detailPendaftar->id;
    //                     $nama_pendaftar = $data->nama;
    //                     $dataPendaftar = $data->detailPendaftar->pendaftar_id;

    //                     /**
    //                      * TODO 'Masih ada BUG'
    //                      */
    //                     // dd($cek_pembayaran_bni['trx_amount']);
    //                     // if ($nomer_va != NULL) {
    //                     //     $cek_pembayaran_bni = $this->CekPembayaranVAUKT($request);
    //                     //     if ($cek_pembayaran_bni['payment_amount'] == $cek_pembayaran_bni['trx_amount']) {
    //                     //         $StatusPembayaran =  DetailPendaftar::where('pendaftar_id', $dataPendaftar)->update([
    //                     //             'status_pembayaran' => 'sudah',
    //                     //         ]);
    //                     //     }
    //                     // }
    //                     // dd($id_pendaftar);
    //                     return view('pendaftar.dashboard.dashboard-ukt', compact('nomer_va', 'expired_va', 'tata_cara', 'nominal_ukt', 'nama_pendaftar', 'id_pendaftar', 'dataPendaftar'));
    //                 } else {
    //                     if ($data->detailPendaftar->status_acc == 'sudah') {
    //                         // Redirect ke halaman ujian
    //                         return redirect()->route('ujian.index', $data->id);
    //                     } elseif ($data->detailPendaftar->status_acc == NULL) {
    //                         // Redirect kembali ke halaman kelengkapan data
    //                         return redirect()->route('kelengkapan-data.edit', ['id' => $data]);
    //                     } else {
    //                         return redirect(route('bukti.show', $data->id));
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }
    // public function index(Request $request)
    // {
    //     if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3) {
    //         // Admin atau panitia
    //         $total_pendaftar = Pendaftar::count();
    //         $total_belum_bayar_pendaftaran = DetailPendaftar::whereNull('status_pendaftaran')->count();
    //         $total_belum_bayar_ukt = DetailPendaftar::where('status_pembayaran', 'belum')->count();
    //         $total_diterima = DetailPendaftar::where('status_acc', 'sudah')->count();
    //         $total_belum_diterima = DetailPendaftar::whereNull('status_acc')->count();
    
    //         $data = [
    //             'total_pendaftar' => $total_pendaftar,
    //             'total_belum_bayar_pendaftaran' => $total_belum_bayar_pendaftaran,
    //             'total_belum_bayar_ukt' => $total_belum_bayar_ukt,
    //             'total_diterima' => $total_diterima,
    //             'total_belum_diterima' => $total_belum_diterima,
    //         ];
    
    //         return view('admin.dashboard', compact('data'));
    //     } else {
    //         // Pendaftar
    //         $pendaftar = Pendaftar::where('user_id', auth()->user()->id)->get();
    //         $tata_cara = TataCara::where('jenis', '!=', 'pendaftaran')->get()->groupBy('jenis', 'ASC');
    
    //         $data = null;
    //         foreach ($pendaftar as $value) {
    //             if ($value->gelombang_id == session('gelombang_id')) {
    //                 $data = $value;
    //                 session(['pendaftar_id' => $data->id]);
    //                 break;
    //             }
    //         }
    
    //         if ($data == null) {
    //             Session::flush();
    //             Auth::logout();
    //             return redirect('login')->with('error_gelombang', 'Anda tidak terdaftar di gelombang yang dipilih');
    //         } else {
    //             if ($data->detailPendaftar) {
    //                 if ($data->detailPendaftar->status_pembayaran_pendaftaran == null) {
    //                     $dataPendaftar = $data->detailPendaftar->pendaftar_id;
    //                     $nomer_va = $data->detailPendaftar->va_pendaftaran;
    //                     $expired_va = $data->detailPendaftar->datetime_expired;
    //                     return view('pendaftar.dashboard.dashboard-pendaftaran', compact('nomer_va', 'expired_va', 'tata_cara', 'dataPendaftar'));
    //                 } elseif ($data->detailPendaftar->status_pembayaran_pendaftaran == 'sudah') {
    //                     if ($data->detailPendaftar->status_pendaftaran != null) {
    //                         return redirect()->route('bukti.bukti-pendaftaran', $data->id);
    //                     } else {
    //                         // Redirect ke halaman untuk melengkapi biodata diri
    //                     }
    //                 }
    
    //                 if ($data->detailPendaftar) {
    //                     if ($data->detailPendaftar->nominal_ukt == null) {
    //                         return view('pendaftar.dashboard.dashboard-belum-ukt');
    //                     } elseif ($data->detailPendaftar->status_ukt == 'sudah') {
    //                         $nomer_va = $data->detailPendaftar->va_ukt;
    //                         $expired_va = $data->detailPendaftar->datetime_expired_ukt;
    //                         $nominal_ukt = $data->detailPendaftar->nominal_ukt;
    //                         $id_pendaftar = $data->detailPendaftar->id;
    //                         $nama_pendaftar = $data->nama;
    //                         $dataPendaftar = $data->detailPendaftar->pendaftar_id;
    //                         if ($data->detailPendaftar->status_acc == 'sudah') {
    //                             return redirect()->route('bukti.show', $data->id); // Arahkan ke halaman show jika sudah punya NIM
    //                         } else {
    //                             return view('pendaftar.dashboard.dashboard-ukt', compact('nomer_va', 'expired_va', 'nominal_ukt', 'nama_pendaftar', 'id_pendaftar', 'dataPendaftar', 'tata_cara'));
    //                         }
    //                     } else {
    //                         return redirect(route('bukti.show', $data->id));
    //                     }
    //                 } else {
    //                     return redirect()->route('error.page');
    //                 }
                    
    //             }
    //         }
    //     }
    // }
    public function index(Request $request)
    {
        if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3) {
            // Admin atau panitia
            $total_pendaftar = Pendaftar::count();
            $total_belum_bayar_pendaftaran = DetailPendaftar::whereNull('status_pendaftaran')->count();
            $total_belum_bayar_ukt = DetailPendaftar::where('status_pembayaran', 'belum')->count();
            $total_diterima = DetailPendaftar::where('status_acc', 'sudah')->count();
            $total_belum_diterima = DetailPendaftar::whereNull('status_acc')->count();
    
            $data = [
                'total_pendaftar' => $total_pendaftar,
                'total_belum_bayar_pendaftaran' => $total_belum_bayar_pendaftaran,
                'total_belum_bayar_ukt' => $total_belum_bayar_ukt,
                'total_diterima' => $total_diterima,
                'total_belum_diterima' => $total_belum_diterima,
            ];
    
            return view('admin.dashboard', compact('data'));
        } else {
            // Pendaftar
            $pendaftar = Pendaftar::where('user_id', auth()->user()->id)->get();
            $tata_cara = TataCara::where('jenis', '!=', 'pendaftaran')->get()->groupBy('jenis', 'ASC');
    
            $data = null;
            foreach ($pendaftar as $value) {
                if ($value->gelombang_id == session('gelombang_id')) {
                    $data = $value;
                    session(['pendaftar_id' => $data->id]);
                    break;
                }
            }
    
            if ($data == null) {
                Session::flush();
                Auth::logout();
                return redirect('login')->with('error_gelombang', 'Anda tidak terdaftar di gelombang yang dipilih');
            } else {
                if ($data->detailPendaftar) {
                    // Logika berdasarkan status pendaftaran
                    if ($data->detailPendaftar->status_pendaftaran === null) {
                        // Jika status pendaftaran belum diisi
                        $dataPendaftar = $data->detailPendaftar->pendaftar_id;
                        $nomer_va = $data->detailPendaftar->va_pendaftaran;
                        $expired_va = $data->detailPendaftar->datetime_expired;
                        return view('pendaftar.dashboard.dashboard-pendaftaran', compact('nomer_va', 'expired_va', 'tata_cara', 'dataPendaftar'));
                    } elseif ($data->detailPendaftar->status_pendaftaran === 'sudah') {
                        // Jika status pendaftaran adalah "sudah"
                        if ($data->detailPendaftar->status_kelengkapan_data === 'sudah' && $data->detailPendaftar->status_acc === 'sudah') {
                            // Jika kelengkapan data sudah divalidasi dan status acc sudah 'sudah'
                            if ($data->detailPendaftar->status_ukt === 'sudah') {
                                // Jika status UKT sudah 'sudah', tampilkan view dashboard-ukt
                                $nomer_va = $data->detailPendaftar->va_ukt;
                                $expired_va = $data->detailPendaftar->datetime_expired_ukt;
                                $nominal_ukt = $data->detailPendaftar->nominal_ukt;
                                $id_pendaftar = $data->detailPendaftar->id;
                                $nama_pendaftar = $data->nama;
                                $dataPendaftar = $data->detailPendaftar->pendaftar_id;
                                return view('pendaftar.dashboard.dashboard-ukt', compact(
                                    'nomer_va', 
                                    'expired_va', 
                                    'nominal_ukt', 
                                    'nama_pendaftar', 
                                    'id_pendaftar', 
                                    'dataPendaftar', 
                                    'tata_cara'
                                ));
                            } else {
                                // Jika status UKT belum 'sudah', arahkan ke halaman kelengkapan-data-lanjutan
                                return redirect()->route('kelengkapan-data.lanjutan.index', $data->id);
                            }
                        } elseif ($data->detailPendaftar->status_kelengkapan_data === 'sudah') {
                            // Jika kelengkapan data sudah divalidasi, tampilkan tampilan bukti pendaftaran
                            return redirect()->route('bukti.bukti-pendaftaran', $data->id);
                        } else {
                            // Jika kelengkapan data belum selesai, tampilkan halaman kelengkapan data
                            return redirect()->route('kelengkapan-data.edit', $data->id);
                        }
                    } else {
                        // Default: Jika status pendaftaran tidak null dan tidak "sudah"
                        return redirect()->route('bukti.bukti-pendaftaran', $data->id);
                    }
                    
                    
                    
    
                    // Logika berdasarkan status UKT
                    if ($data->detailPendaftar->nominal_ukt == null) {
                        return view('pendaftar.dashboard.dashboard-belum-ukt');
                    } elseif ($data->detailPendaftar->status_ukt == 'sudah') {
                        $nomer_va = $data->detailPendaftar->va_ukt;
                        $expired_va = $data->detailPendaftar->datetime_expired_ukt;
                        $nominal_ukt = $data->detailPendaftar->nominal_ukt;
                        $id_pendaftar = $data->detailPendaftar->id;
                        $nama_pendaftar = $data->nama;
                        $dataPendaftar = $data->detailPendaftar->pendaftar_id;
                        
                        // Logika berdasarkan status acc
                        if ($data->detailPendaftar->status_pembayaran == 'sudah') {
                            return redirect()->route('bukti.show', $data->id); // Arahkan ke halaman show jika sudah punya NIM
                        } else {
                            return view('pendaftar.dashboard.dashboard-ukt', compact(
                                'nomer_va', 
                                'expired_va', 
                                'nominal_ukt', 
                                'nama_pendaftar', 
                                'id_pendaftar', 
                                'dataPendaftar', 
                                'tata_cara'
                            ));
                        }
                    } else {
                        return redirect(route('bukti.show', $data->id));
                    }
                } else {
                    return redirect()->route('error.page');
                }
            }
        }
    }
    

    


// public function index(Request $request)
// {
    
//     if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3 || auth()->user()->role_id == 2) {

//         // Data admin
//         $total_pendaftar = Pendaftar::count();
//         $total_belum_bayar_pendaftaran = DetailPendaftar::whereNull('status_pendaftaran')->count();
//         $total_belum_bayar_ukt = DetailPendaftar::where('status_pembayaran', 'belum')->count();
//         $total_diterima = DetailPendaftar::where('status_acc', 'sudah')->count();
//         $total_belum_diterima = DetailPendaftar::whereNull('status_acc')->count();

//         $data = [
//             'total_pendaftar' => $total_pendaftar,
//             'total_belum_bayar_pendaftaran' => $total_belum_bayar_pendaftaran,
//             'total_belum_bayar_ukt' => $total_belum_bayar_ukt,
//             'total_diterima' => $total_diterima,
//             'total_belum_diterima' => $total_belum_diterima
//         ];

//         return view('admin.dashboard', compact('data'));

//     } else {
//         // Data pendaftar
//         $pendaftar = Pendaftar::where('user_id', auth()->user()->id)->get();
//         $tata_cara = TataCara::where('jenis', '!=', 'pendaftaran')->get()->groupBy('jenis', 'ASC');

//         $data = null;
//         foreach ($pendaftar as $value) {
//             if ($value->gelombang_id == session('gelombang_id')) {
//                 $data = $value;
//                 session(['pendaftar_id' => $data->id]);
//             }
//         }

//         if ($data == null) {
//             Session::flush();
//             Auth::logout();
//             return redirect('login')->with('error_gelombang', 'Anda tidak terdaftar di gelombang yang dipilih');
//         } else {

//             if ($data->detailPendaftar && $data->detailPendaftar->status_pendaftaran == null) {
//                 $nomer_va = $data->detailPendaftar->va_pendaftaran;
//                 $expired_va = $data->detailPendaftar->datetime_expired;
        
//                 return view('pendaftar.dashboard.dashboard-pendaftaran', compact('nomer_va', 'expired_va', 'tata_cara'));
//             } elseif ($data->detailPendaftar && $data->detailPendaftar->status_pendaftaran == 'sudah') {
//                 return redirect()->route('kelengkapan-data.edit', $data->id);
//             } elseif ($data->detailPendaftar && $data->detailPendaftar->nominal_ukt == null) {
//                 return view('pendaftar.dashboard.dashboard-belum-ukt');
//             } elseif ($data->detailPendaftar && $data->detailPendaftar->nominal_ukt != null && $data->detailPendaftar->status_pembayaran == null) {
//                 $nomer_va = $data->detailPendaftar->va_ukt;
//                 $expired_va = $data->detailPendaftar->datetime_expired_ukt;
//                 $nominal_ukt = $data->detailPendaftar->nominal_ukt;
//                 $id_pendaftar = $data->detailPendaftar->id;
//                 $nama_pendaftar = $data->nama;
//                 $dataPendaftar = $data->detailPendaftar->pendaftar_id;
//                 return view('pendaftar.dashboard.dashboard-ukt', compact('nomer_va', 'expired_va', 'tata_cara', 'nominal_ukt', 'nama_pendaftar', 'id_pendaftar', 'dataPendaftar'));
//             } else {
//                 return redirect(route('bukti.show', $data->id));
//             }
//         }
//     }
// }
// public function index(Request $request)
// {
//     // Cek data user yang sedang login
//     dd(auth()->user());

//     if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3 || auth()->user()->role_id == 2) {

//         // Data admin
//         $total_pendaftar = Pendaftar::count();
//         $total_belum_bayar_pendaftaran = DetailPendaftar::whereNull('status_pendaftaran')->count();
//         $total_belum_bayar_ukt = DetailPendaftar::where('status_pembayaran', 'belum')->count();
//         $total_diterima = DetailPendaftar::where('status_acc', 'sudah')->count();
//         $total_belum_diterima = DetailPendaftar::whereNull('status_acc')->count();

//         $data = [
//             'total_pendaftar' => $total_pendaftar,
//             'total_belum_bayar_pendaftaran' => $total_belum_bayar_pendaftaran,
//             'total_belum_bayar_ukt' => $total_belum_bayar_ukt,
//             'total_diterima' => $total_diterima,
//             'total_belum_diterima' => $total_belum_diterima
//         ];

//         return view('admin.dashboard', compact('data'));

//     } else {
//         // Data pendaftar
//         $pendaftar = Pendaftar::where('user_id', auth()->user()->id)->get();
//         dd($pendaftar); // Cek data pendaftar

//         $tata_cara = TataCara::where('jenis', '!=', 'pendaftaran')->get()->groupBy('jenis', 'ASC');

//         $data = null;
//         foreach ($pendaftar as $value) {
//             if ($value->gelombang_id == session('gelombang_id')) {
//                 $data = $value;
//                 session(['pendaftar_id' => $data->id]);
//                 dd($data); // Cek data setelah session pendaftar_id di-set
//             }
//         }

//         if ($data == null) {
//             Session::flush();
//             Auth::logout();
//             return redirect('login')->with('error_gelombang', 'Anda tidak terdaftar di gelombang yang dipilih');
//         } else {

//             if ($data->detailPendaftar && $data->detailPendaftar->status_pendaftaran == null) {
//                 dd($data->detailPendaftar); // Cek data detail pendaftar
//                 $nomer_va = $data->detailPendaftar->va_pendaftaran;
//                 $expired_va = $data->detailPendaftar->datetime_expired;
//                 return view('pendaftar.dashboard.dashboard-pendaftaran', compact('nomer_va', 'expired_va', 'tata_cara'));
//             }
//         }
//     }
// }


    public function createVA(Request $request)
    {
        // dd($request->nama_pendaftar);
        // $biaya_pendataran = Pendaftar::where('id', $data['gelombang'])->first();
        //  dd($biaya_pendataran->nominal_pendaftaran);
        // FROM BNI
        $client_id = '21016';
        $secret_key = '6094ecb0bcb62da963f1b50a876ffe02';
        $url = 'https://apibeta.bni-ecollection.com/';

        //cerate VA
        $data_asli = array(
            'client_id' => $client_id,
            'trx_id' => mt_rand(), // fill with Billing ID
            'trx_amount' => $request->nominal_ukt,
            'billing_type' => 'c',
            'type' => 'createbilling',
            'datetime_expired' => date('c', time() + 24 * 3600), // billing will be expired in 2 hours
            'virtual_account' => '',
            'customer_name' => $request->nama_pendaftar,
            'customer_email' => '',
            'customer_phone' => '',
        );
        //cerate VA

        //Cek Pembayaran
        // $data_asli = array(
        // 	'client_id' => $client_id,
        // 	'trx_id' => '1373110458', // fill with Billing ID
        // 	'trx_amount' => '',
        // // 	'billing_type' => 'c',
        // 	'type' => 'inquirybilling',
        // 	'datetime_expired' => '', // billing will be expired in 2 hours
        // 	'virtual_account' => '9882101622121228',
        // 	'customer_name' => '',
        // 	'customer_email' => '',
        // 	'customer_phone' => '',
        // );


        //Cek Pembayaran
        $hashed_string = BniEnc::encrypt(
            $data_asli,
            $client_id,
            $secret_key
        );

        $data = array(
            'client_id' => $client_id,
            'data' => $hashed_string,
        );

        // dd($hashed_string);

        $response = Http::post($url, $data);
        $response_json = json_decode($response, true);
        // dd($response);
        if ($response_json['status'] !== '000') {
            // handling jika gagal
            var_dump($response_json);
        } else {
            $data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
            // $data_response will contains something like this:
            // array(
            // 	'virtual_account' => 'xxxxx',
            // 	'trx_id' => 'xxx',
            // );
            // 	var_dump($data_response);
            $va_bni = $data_response;
            // $trx_id =  $data_response['trx_id'];
            // dd($trx_id);
        }



        return $va_bni;
    }
    public function CekUKTVA(Request $request)
    {
        //   dd($data['nama']);
        $va_bni = $this->createVA($request);
        // dd($va_bni);
        // FROM BNI
        $client_id = '21016';
        $secret_key = '6094ecb0bcb62da963f1b50a876ffe02';
        $url = 'https://apibeta.bni-ecollection.com/';

        //cerate VA
        // $data_asli = array(
        // 	'client_id' => $client_id,
        // 	'trx_id' => mt_rand(), // fill with Billing ID
        // 	'trx_amount' => 10000,
        // 	'billing_type' => 'c',
        // 	'type' => 'createbilling',
        // 	'datetime_expired' => date('c', time() + 2 * 3600), // billing will be expired in 2 hours
        // 	'virtual_account' => '',
        // 	'customer_name' => $data['nama'],
        // 	'customer_email' => '',
        // 	'customer_phone' => '',
        // );
        //cerate VA

        //Cek Pembayaran
        $data_asli = array(
            'client_id' => $client_id,
            'trx_id' => $va_bni['trx_id'], // fill with Billing ID
            'trx_amount' => '',
            // 	'billing_type' => 'c',
            'type' => 'inquirybilling',
            'datetime_expired' => '', // billing will be expired in 2 hours
            'virtual_account' => $va_bni['virtual_account'],
            'customer_name' => '',
            'customer_email' => '',
            'customer_phone' => '',
        );


        //Cek Pembayaran
        $hashed_string = BniEnc::encrypt(
            $data_asli,
            $client_id,
            $secret_key
        );

        $data = array(
            'client_id' => $client_id,
            'data' => $hashed_string,
        );

        // dd($hashed_string);

        $response = Http::post($url, $data);
        $response_json = json_decode($response, true);
        // dd($response);
        if ($response_json['status'] !== '000') {
            // handling jika gagal
            var_dump($response_json);
        } else {
            $data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
            // $data_response will contains something like this:
            // array(
            // 	'virtual_account' => 'xxxxx',
            // 	'trx_id' => 'xxx',
            // );
            // 	var_dump($data_response);
            $va = $data_response;
            // $trx_id =  $data_response['trx_id'];
            // dd($va);
        }

        return $va;
    }
    public function CekUKT(Request $request)
    {
        // dd($request->id_pendaftar);
        $va_bni = $this->createVA($request);
        $cek_pembayaran_bni = $this->CekUKTVA($request);
        $detail_pendaftar_update = DetailPendaftar::where('id', $request->id_pendaftar)->update([
            'va_ukt' => $va_bni['virtual_account'],
            'trx_va_ukt' => $va_bni['trx_id'],
            'datetime_expired_ukt' => $cek_pembayaran_bni['datetime_expired'],
        ]);
        return $detail_pendaftar_update;
    }
    public function CekPembayaranVAPendaftaran(Request $request)
    {
        //   dd($data['nama']);
        $pendaftar = Pendaftar::where('user_id', auth()->user()->id)->first();
        // $cek_bayar = DetailPendaftar::where('id', $request->id_pendaftar)->first();
        // dd($pendaftar->detailPendaftar);
        // FROM BNI
        $client_id = '21016';
        $secret_key = '6094ecb0bcb62da963f1b50a876ffe02';
        $url = 'https://apibeta.bni-ecollection.com/';

        //cerate VA
        // $data_asli = array(
        // 	'client_id' => $client_id,
        // 	'trx_id' => mt_rand(), // fill with Billing ID
        // 	'trx_amount' => 10000,
        // 	'billing_type' => 'c',
        // 	'type' => 'createbilling',
        // 	'datetime_expired' => date('c', time() + 2 * 3600), // billing will be expired in 2 hours
        // 	'virtual_account' => '',
        // 	'customer_name' => $data['nama'],
        // 	'customer_email' => '',
        // 	'customer_phone' => '',
        // );
        //cerate VA

        //Cek Pembayaran
        $data_asli = array(
            'client_id' => $client_id,
            'trx_id' => $pendaftar->detailPendaftar->trx_va, // fill with Billing ID
            'trx_amount' => '',
            // 	'billing_type' => 'c',
            'type' => 'inquirybilling',
            'datetime_expired' => '', // billing will be expired in 2 hours
            'virtual_account' => $pendaftar->detailPendaftar->va_pendaftaran,
            'customer_name' => '',
            'customer_email' => '',
            'customer_phone' => '',
        );


        //Cek Pembayaran
        $hashed_string = BniEnc::encrypt(
            $data_asli,
            $client_id,
            $secret_key
        );

        $data = array(
            'client_id' => $client_id,
            'data' => $hashed_string,
        );

        // dd($hashed_string);

        $response = Http::post($url, $data);
        $response_json = json_decode($response, true);
        // dd($response);
        if ($response_json['status'] !== '000') {
            // handling jika gagal
            var_dump($response_json);
        } else {
            $data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
            // $data_response will contains something like this:
            // array(
            // 	'virtual_account' => 'xxxxx',
            // 	'trx_id' => 'xxx',
            // );
            // 	var_dump($data_response);
            $va_pembayaran = $data_response;
            // $trx_id =  $data_response['trx_id'];
            // dd($va);
        }

        return $va_pembayaran;
    }
    public function CekPembayaranVAUKT(Request $request)
    {
        //   dd($data['nama']);
        $pendaftar = Pendaftar::where('user_id', auth()->user()->id)->first();
        // $cek_bayar = DetailPendaftar::where('id', $request->id_pendaftar)->first();
        // dd($pendaftar->detailPendaftar);
        // FROM BNI
        $client_id = '21016';
        $secret_key = '6094ecb0bcb62da963f1b50a876ffe02';
        $url = 'https://apibeta.bni-ecollection.com/';

        //cerate VA
        // $data_asli = array(
        // 	'client_id' => $client_id,
        // 	'trx_id' => mt_rand(), // fill with Billing ID
        // 	'trx_amount' => 10000,
        // 	'billing_type' => 'c',
        // 	'type' => 'createbilling',
        // 	'datetime_expired' => date('c', time() + 2 * 3600), // billing will be expired in 2 hours
        // 	'virtual_account' => '',
        // 	'customer_name' => $data['nama'],
        // 	'customer_email' => '',
        // 	'customer_phone' => '',
        // );
        //cerate VA

        //Cek Pembayaran
        $data_asli = array(
            'client_id' => $client_id,
            'trx_id' => $pendaftar->detailPendaftar->trx_va_ukt, // fill with Billing ID
            'trx_amount' => '',
            // 	'billing_type' => 'c',
            'type' => 'inquirybilling',
            'datetime_expired' => '', // billing will be expired in 2 hours
            'virtual_account' => $pendaftar->detailPendaftar->va_ukt,
            'customer_name' => '',
            'customer_email' => '',
            'customer_phone' => '',
        );


        //Cek Pembayaran
        $hashed_string = BniEnc::encrypt(
            $data_asli,
            $client_id,
            $secret_key
        );

        $data = array(
            'client_id' => $client_id,
            'data' => $hashed_string,
        );

        // dd($hashed_string);

        $response = Http::post($url, $data);
        $response_json = json_decode($response, true);
        // dd($response);
        if ($response_json['status'] !== '000') {
            // handling jika gagal
            var_dump($response_json);
        } else {
            $data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
            // $data_response will contains something like this:
            // array(
            // 	'virtual_account' => 'xxxxx',
            // 	'trx_id' => 'xxx',
            // );
            // 	var_dump($data_response);
            $va_pembayaran = $data_response;
            // $trx_id =  $data_response['trx_id'];
            // dd($va);
        }

        return $va_pembayaran;
    }
}
