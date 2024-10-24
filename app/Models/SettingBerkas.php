<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingBerkas extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function berkas_gelombang_trans()
    {
        return $this->hasMany(BerkasGelombangTransaksi::class, 'berkas_id');
    }
}
