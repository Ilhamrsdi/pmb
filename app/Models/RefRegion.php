<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRegion extends Model
{
    use HasFactory;

    public $table = 'regions';

    public function parent()
    {
        return $this->belongsTo(RefRegion::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(RefRegion::class, 'parent');
    }
    
    public function Pendaftar(){
        return $this->hasMany(Pendaftar::class);
    }
}
