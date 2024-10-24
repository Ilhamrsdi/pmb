<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasGelombangTransaksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function gelombang()
    {
        return $this->belongsTo(GelombangPendaftaran::class);
    }
    public function berkas()
    {
        return $this->belongsTo(SettingBerkas::class, 'berkas_id');
    }
    
}
