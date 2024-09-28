<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    // protected $guarded = ['id'];
    protected $fillable = [
        "id",
        "nama_jurusan",
        "alias_jurusan",
        "status"
    ];

    public $keyType = "string";

    public function programStudi()
    {
        return $this->hasMany(ProgramStudi::class);
    }
}
