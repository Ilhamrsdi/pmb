<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefCountry extends Model
{
    use HasFactory;

    protected $table = 'countries';
    public $keyType = 'string';
    
    public function pendaftar(){
        return $this->hasOne(Pendaftar::class);
    }
}
