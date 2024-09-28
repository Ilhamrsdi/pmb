<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefPendidikan extends Model
{
    use HasFactory;

    protected $table = 'education_levels';

    public function prodi()
    {
        return $this->hasMany(RefPorgramStudi::class);
    }
}
