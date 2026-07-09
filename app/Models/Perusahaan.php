<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaan';

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'email',
        'negara_asal',
        'alamat',
        'no_tlp',
        'jenis_industri',
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
