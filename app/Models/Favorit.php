<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    protected $table = 'favorit';

    protected $fillable = [
        'user_id',
        'negara_id',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function negara()
    {
        return $this->belongsTo(Negara::class);
    }
}
