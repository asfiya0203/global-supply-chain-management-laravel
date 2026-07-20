<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Negara;
use App\Models\DataPelabuhan;

class DataPelabuhanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/pelabuhan.csv');

        if (!file_exists($path)) {
            $this->command->error('File pelabuhan.csv tidak ditemukan!');
            return;
        }

        $file = fopen($path, 'r');
        fgetcsv($file);

        $berhasil = 0;
        $dilewati = 0;

        while (($row = fgetcsv($file)) !== false) {
            $regionName = $row[2] ?? '';
            $namaNegara = trim(explode('--', $regionName)[0]);
            $negara = Negara::where('nama_negara', $namaNegara)->first();

            if (!$negara) {
                $dilewati++;
                continue;
            }

            $latitude = $row[count($row) - 2] ?? null;
            $longitude = $row[count($row) - 1] ?? null;

            $latitude = is_numeric($latitude) ? (float) $latitude : null;
            $longitude = is_numeric($longitude) ? (float) $longitude : null;

            // Simpan atau update data pelabuhan
            DataPelabuhan::updateOrCreate(
                [
                    'negara_id' => $negara->id,
                    'nama_pelabuhan' => $row[3], 
                ],
                [
                    'nama_alternatif' => $row[4] ?? null,
                    'un_locode' => $row[5] ?? null,
                    'wilayah' => $regionName,
                    'ukuran_pelabuhan' => $row[29] ?? null,
                    'tipe_pelabuhan' => $row[30] ?? null,
                    'penggunaan_pelabuhan' => $row[31] ?? null,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]
            );

            $berhasil++;
        }

        fclose($file);

        $this->command->info("Import selesai. Berhasil: {$berhasil}, Dilewati: {$dilewati}");
    }
}
