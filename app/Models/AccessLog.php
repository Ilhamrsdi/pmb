<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'ip_address',
        'accessed_at',
    ];

    // Mengatur agar 'accessed_at' disimpan sebagai tipe date
    protected $dates = ['accessed_at'];

    /**
     * Relasi dengan model User (pengguna yang mengakses)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan 'accessed_at' dalam zona waktu 'Asia/Jakarta'
     */
    public function getAccessedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Jakarta');
    }
}
