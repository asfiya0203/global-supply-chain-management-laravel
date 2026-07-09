<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Negara extends Model
{
    protected $table = 'negara';

    protected $fillable = [
        'nama_negara',
        'kode_iso2',
        'kode_iso3',
        'ibu_kota',
        'wilayah',
        'latitude',
        'longitude',
        'bendera',
    ];

    public function favorit()
    {
        return $this->hasMany(Favorit::class);
    }

    public function dataCuaca()
    {
        return $this->hasMany(DataCuaca::class);
    }

    public function dataPelabuhan()
    {
        return $this->hasMany(DataPelabuhan::class);
    }

    public function dataBencana()
    {
        return $this->hasMany(DataBencana::class);
    }

    public function dataSanksi()
    {
        return $this->hasMany(DataSanksi::class);
    }
    
    public function dataBerita()
    {
        return $this->hasMany(DataBerita::class);
    }

    public function skorRisikoHarian()
    {
        return $this->hasMany(SkorRisikoHarian::class);
    }
}
