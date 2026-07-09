<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBerita extends Model
{
    protected $table = 'data_berita';

    protected $fillable = [
        'negara_id',
        'judul',
        'isi',
        'url_sumber',
        'skor_positif',
        'skor_negatif',
        'sentimen',
        'tanggal_duplikasi',
        'sumber_api',
        'waktu_data',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
