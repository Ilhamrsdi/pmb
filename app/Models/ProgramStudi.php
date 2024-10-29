<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    // protected $guarded = ['id'];
    protected $fillable = [
        'id',
        'jurusan_id',
        'kode_program_studi',
        'nama_program_studi',
        'jenjang_pendidikan',
        'akreditasi',
        'kode_nim',
        'nomer_urut_nim',
        'status',
    ];

    public $keyType = "string";

    public function pendaftar()
    {
        return $this->hasOne(Pendaftar::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }
    public function ukts()
    {
        return $this->hasMany(Ukt::class);
    }
}
