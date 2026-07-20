<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBerita extends Model
{
    protected $table = 'data_berita';

    protected $fillable = [
        'negara_id',
        'judul',
        'deskripsi',
        'url',
        'sumber',
        'kategori',
        'skor_positif',
        'skor_negatif',
        'sentimen',
        'skor_risiko_berita',
        'tanggal_publikasi',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
