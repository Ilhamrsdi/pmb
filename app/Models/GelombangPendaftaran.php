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
        'program_studi_1ids',
        'program_studi_2ids',
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
    public function prodiLain()
    {
        return $this->belongsToMany(ProdiLain::class, 'gelombang_prodi_lain', 'gelombang_id', 'prodi_lain_id');
    }

  // Relasi ke Program Studi
  public function programStudi()
  {
      return $this->belongsToMany(RefPorgramStudi::class, 'gelombang_program_studi', 'gelombang_id', 'program_studi_id');
  }
  

}
