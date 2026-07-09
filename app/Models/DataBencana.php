<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBencana extends Model
{
    protected $table = 'data_bencana';

    protected $fillable = [
        'negara_id',
        'jenis_bencana',
        'tingkat_keparahan',
        'lokasi',
        'deskripsi',
        'sumber_api',
        'waktu_data',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
