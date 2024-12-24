<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtributGambar extends Model
{
    use HasFactory;

    protected $fillable = ['atribut_id', 'gambar', 'jenis_gambar', 'ukuran'];
}

