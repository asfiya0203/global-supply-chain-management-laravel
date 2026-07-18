<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KursMataUang extends Model
{
    protected $table = 'kurs_mata_uang';

    protected $fillable = [
        'negara_id',
        'kode_mata_uang',
        'kurs_ke_usd',
        'perubahan_persen',
        'tingkat_risiko',
        'tanggal',
        'sumber_api',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
