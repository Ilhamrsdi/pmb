<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlurPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'alur_pendaftarans'; // Nama tabel di database
    protected $fillable = ['nama_alur', 'kriteria', 'gambar']; // Kolom yang dapat diisi
}
