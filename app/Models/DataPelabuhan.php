<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPelabuhan extends Model
{
    protected $table = 'data_pelabuhan';

    protected $fillable = [
        'negara_id',
        'nama_pelabuhan',
        'nama_alternatif',
        'un_locode',
        'wilayah',
        'ukuran_pelabuhan',
        'tipe_pelabuhan',
        'penggunaan_pelabuhan',
        'latitude',
        'longitude',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
