<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pendaftar extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'nama',
        'no_hp',
        'sekolah',
        'program_studi_id',
        'gelombang_id',
        'ukt_id',
        'nim'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detailPendaftar()
    {
        return $this->hasOne(DetailPendaftar::class);
    }

    public function wali()
    {
        return $this->hasOne(Wali::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    // public function programStudi()
    // {
    //     return $this->belongsTo(RefPorgramStudi::class, 'program_studi_id', 'id');
    // }

    public function gelombangPendaftaran()
    {
        return $this->belongsTo(GelombangPendaftaran::class, 'gelombang_id', 'id');
    }

    public function atribut()
    {
        return $this->hasOne(Atribut::class);
    }

    public function ukt()
    {
        return $this->belongsTo(Ukt::class, 'ukt_id', 'id');
    }

    public function tesMaba()
    {
        return $this->belongsTo(TesMaba::class, 'test_maba_id', 'id');
    }

    public function refNegara()
    {
        return $this->belongsTo(RefCountry::class, 'negara', 'id');
    }

    public function refRegion()
    {
        return $this->belongsTo(refRegion::class);
    }

    public function generateNIM()
    {
        // Menghasilkan NIM berdasarkan format yang diinginkan
        // Contoh: Kode Kampus + Tahun Masuk + Kode Prodi + Nomor Urut
        $tahun_masuk = date('y');
        $kode_kampus = 36;
        $kode_prodi = $this->programStudi->kode_prodi;
        $kode_nim = $this->programStudi->kode_nim;
        // Mengambil nomor urut terakhir untuk menghasilkan NIM baru
        $nomor_urut = $this->getLastNomorUrut() + 1; // Anda perlu mendefinisikan logika getLastNomorUrut()

        return $kode_kampus . $tahun_masuk . $kode_prodi . $kode_nim . str_pad($nomor_urut, 3, '0', STR_PAD_LEFT);
    }

    // private function getLastNomorUrut()
    // {
    //     // Logic to get the last 'nomor_urut' from the database
    //     return static::where('kode_prodi', $this->kode_prodi)->max('nomor_urut') ?? 0;
    // }
}
