<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Guid\Guid;
use Ramsey\Uuid\Guid\GuidInterface;
class ProdiLain extends Model
{
    use HasFactory;

    protected $keyType = 'string';  // UUID adalah tipe data string
    public $incrementing = false; 
    protected $table = 'prodi_lain'; // pastikan nama tabel
    protected $fillable = ['name', 'kampus', 'alamat_kampus', 'telepon_kampus', 'email_kampus', 'website_kampus', 'status'];

    protected static function booted()
    {
        static::creating(function ($model) {
            // Membuat UUID jika belum ada
            if (!$model->id) {
                $model->id = (string) Guid::uuid4(); // Menggunakan UUID versi 4
            }
        });
    }
    // Relasi ke model Pendaftar
    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class, 'prodi_lain_id');
    }
    public function gelombangs()
{
    return $this->belongsToMany(GelombangPendaftaran::class, 'gelombang_prodi_lain', 'prodi_lain_id', 'gelombang_id');
}

}
