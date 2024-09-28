<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesMaba extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pendaftar()
    {
        return $this->hasOne(Pendaftar::class);
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
              'jumlah_soal',
              'tanggal_tes',
              'waktu_tes',
            
      ];
}
