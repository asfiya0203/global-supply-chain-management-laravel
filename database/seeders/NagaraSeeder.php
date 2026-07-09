<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NagaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            DB::table('negara')->insertOrIgnore([
        [
            'nama_negara' => 'Amerika Serikat',
            'kode_iso2'   => 'US',
            'kode_iso3'   => 'USA',
            'ibu_kota'    => 'Washington D.C.',
            'wilayah'     => 'Americas',
            'latitude'    => 38.8951000,
            'longitude'   => -77.0364000,
            'bendera'     => 'https://flagcdn.com/us.svg',
        ],
        [
            'nama_negara' => 'Tiongkok',
            'kode_iso2'   => 'CN',
            'kode_iso3'   => 'CHN',
            'ibu_kota'    => 'Beijing',
            'wilayah'     => 'Asia',
            'latitude'    => 39.9042000,
            'longitude'   => 116.4074000,
            'bendera'     => 'https://flagcdn.com/cn.svg',
        ],
        [
            'nama_negara' => 'Jerman',
            'kode_iso2'   => 'DE',
            'kode_iso3'   => 'DEU',
            'ibu_kota'    => 'Berlin',
            'wilayah'     => 'Europe',
            'latitude'    => 52.5200000,
            'longitude'   => 13.4050000,
            'bendera'     => 'https://flagcdn.com/de.svg',
        ],
        [
            'nama_negara' => 'Jepang',
            'kode_iso2'   => 'JP',
            'kode_iso3'   => 'JPN',
            'ibu_kota'    => 'Tokyo',
            'wilayah'     => 'Asia',
            'latitude'    => 35.6762000,
            'longitude'   => 139.6503000,
            'bendera'     => 'https://flagcdn.com/jp.svg',
        ],
        [
            'nama_negara' => 'Indonesia',
            'kode_iso2'   => 'ID',
            'kode_iso3'   => 'IDN',
            'ibu_kota'    => 'Jakarta',
            'wilayah'     => 'Asia',
            'latitude'    => -6.2088000,
            'longitude'   => 106.8456000,
            'bendera'     => 'https://flagcdn.com/id.svg',
        ],
    ]);
    }
}
