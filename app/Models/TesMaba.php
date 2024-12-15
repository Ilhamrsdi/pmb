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
}

