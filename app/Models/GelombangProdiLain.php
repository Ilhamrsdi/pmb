<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GelombangProdiLain extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function gelombang()
    {
        return $this->belongsTo(GelombangPendaftaran::class, 'gelombang_id');
    }
    

    public function prodiLain()
    {
        return $this->belongsTo(ProdiLain::class, 'prodi_lain_id');
    }
}

