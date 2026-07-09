<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkorRisikoHarian extends Model
{
    protected $table = 'skor_risiko_harian';

    protected $fillable = [
        'negara_id',
        'tanggal',
        'skor_cuaca',
        'skor_bencana',
        'skor_pelabuhan',
        'skor_sanksi',
        'skor_berita',
        'skor_total',
        'level_risiko',
        'ringkasan_ai',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
