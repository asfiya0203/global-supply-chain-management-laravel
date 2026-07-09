<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPelabuhan extends Model
{
    protected $table = 'data_pelabuhan';

    protected $fillable = [
        'negara_id',
        'nama_pelabuhan',
        'status',
        'tingkat_kepadatan',
        'estimasi_keterlambatan',
        'sumber_api',
        'waktu_data',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
