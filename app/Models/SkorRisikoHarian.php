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
        'skor_berita',
        'skor_kurs',
        'skor_ekonomi',
        'skor_total',
        'level_risiko',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'skor_cuaca' => 'decimal:2',
        'skor_bencana' => 'decimal:2',
        'skor_berita' => 'decimal:2',
        'skor_kurs' => 'decimal:2',
        'skor_ekonomi' => 'decimal:2',
        'skor_total' => 'decimal:2',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
