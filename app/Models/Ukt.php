<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukt extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pendaftar()
    {
        return $this->hasOne(Pendaftar::class, 'id',);
    }
    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id', 'id');
    }
    public function gelombangPendaftaran()
    {
        return $this->belongsTo(GelombangPendaftaran::class, 'gelombang_pendaftaran_id', 'id');
    }
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id', 'id');
    }
}
