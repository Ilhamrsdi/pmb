<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atribut extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id', 'id');
    }
}
