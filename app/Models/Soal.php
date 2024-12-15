<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'tes_maba_id',
        'soal',
        'jawaban',        
        'jawaban1',        
        'jawaban2',        
        'jawaban3',        
    ];

    public function tesMaba()
    {
        return $this->belongsTo(TesMaba::class);
    }
}
