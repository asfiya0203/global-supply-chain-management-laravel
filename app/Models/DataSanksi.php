<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSanksi extends Model
{
    protected $table = 'data_sanksi';

    protected $fillable = [
        'negara_id',
        'jenis_sanksi',
        'negara_pemberi_sanksi',
        'status',
        'deskripsi',
        'sumber_api',
        'waktu_data',
    ];

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
