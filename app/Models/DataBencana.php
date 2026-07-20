<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBencana extends Model
{
    protected $table = 'data_bencana';

    protected $fillable = [
        'negara_id',
        'judul',
        'url',
        'sumber',
        'jenis_bencana',
        'skor_negatif',
        'skor_risiko_bencana',
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
