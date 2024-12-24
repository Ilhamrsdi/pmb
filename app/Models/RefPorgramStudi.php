<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPorgramStudi extends Model
{
    use HasFactory;

    public $table = 'ref.study_programs';
    public $keyType = 'string';
    public $incrementing = false;  

    public function pendaftar()
    {
        return $this->hasOne(Pendaftar::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(RefJurusan::class, 'major_id');
    }

    public function pendidikan()
    {
        return $this->belongsTo(RefPendidikan::class, 'education_level_id', 'id');
    }
    
    public function gelombang()
    {
        return $this->belongsToMany(GelombangPendaftaran::class, 'gelombang_program_studi', 'program_studi_id', 'gelombang_id');
    }
}
