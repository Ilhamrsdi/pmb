<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefJurusan extends Model
{
    use HasFactory;

    public $table = 'majors';
    public $keyType = "string";

    public function program_studi()
    {
        return $this->hasMany(RefPorgramStudi::class);
    }
}
