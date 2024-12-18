<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GelombangPendaftaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        "nama_gelombang",
        "tahun_ajaran",
        "tanggal_mulai",
        "tanggal_selesai",
        "status",
        "deskripsi",
        "biaya_pendaftaran",
        "biaya_administrasi",
        "tanggal_ujian",
        "tempat_ujian",
        "kuota_pendaftar",
    ];

    public function pendaftar()
    {
        return $this->hasOne(Pendaftar::class);
    }
    public function ukts()
    {
        return $this->hasMany(Ukt::class);
    }

    public function berkas()
    {
        return $this->hasMany(BerkasGelombangTransaksi::class, 'berkas_id');
    }
}
