<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiLain extends Model
{
    use HasFactory;

    protected $table = 'prodi_lain'; // pastikan nama tabel
    protected $fillable = ['name', 'kampus', 'alamat_kampus', 'telepon_kampus', 'email_kampus', 'website_kampus', 'status'];


    // Relasi ke model Pendaftar
    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class, 'prodi_lain_id');
    }
}
