<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';

    protected $fillable = [
        'perusahaan_id',
        'negara_id',
        'nama_supplier',
        'jenis_industri',
        'tier_supplier',
        'kontak',
        'email',
        'skor_risiko',
        'level_risiko',
        'status',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
