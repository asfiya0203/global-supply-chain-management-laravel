<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorEkonomi extends Model
{
    protected $table = 'indikator_ekonomi';

    protected $fillable = [
        'negara_id',
        'tahun',
        'gdp',
        'inflasi',
        'populasi',
        'ekspor',
        'impor',
        'sumber_api',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
