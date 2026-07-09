<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCuaca extends Model
{
    protected $table = 'data_cuaca';

    protected $fillable = [
        'negara_id',
        'suhu',
        'kelembapan',
        'kecepatan_angin',
        'kondisi_cuaca',
        'tingkat_risiko',
        'sumber_api',
        'waktu_data',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
