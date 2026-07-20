<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Negara;
use App\Models\DataBencana;
use Carbon\Carbon;

class BeritaBencanaService
{
    // Query pencarian hanya untuk bencana besar
    private $kategoriList = [
        'gempa' => 'earthquake (magnitude 6 OR magnitude 7 OR magnitude 8 OR major earthquake OR strong earthquake OR devastating earthquake)',
        'banjir' => 'massive flood OR severe flooding OR flood disaster OR flood emergency OR inundated',
        'topan' => 'super typhoon OR major hurricane OR category 3 OR category 4 OR category 5',
        'longsor' => 'major landslide OR deadly landslide OR highway blocked landslide',
        'kebakaran' => 'massive wildfire OR forest fire disaster OR wildfire emergency',
        'bencana_nasional' => 'state of emergency OR national disaster OR disaster zone OR evacuation order',
    ];

    // Kata negatif dengan bobot
    private $kataNegatif = [
        'earthquake' => 3,
        'magnitude' => 2,
        'tsunami' => 3,
        'flood' => 2,
        'flooding' => 2,
        'inundated' => 3,
        'typhoon' => 3,
        'hurricane' => 3,
        'super typhoon' => 4,
        'wildfire' => 2,
        'forest fire' => 2,
        'landslide' => 2,
        'eruption' => 3,
        'drought' => 2,
        'state of emergency' => 4,
        'national disaster' => 4,
        'disaster zone' => 3,
        'evacuation' => 3,
    ];

    public function updateBeritaBencana($output = null)
    {
        $semuaNegara = Negara::all();
        $berhasil = 0;
        $gagal = 0;

        foreach ($semuaNegara as $negara) {
            foreach ($this->kategoriList as $jenisBencana => $queryBencana) {
                if ($output) {
                    $output->info("Mengambil bencana {$negara->nama_negara} - {$jenisBencana}");
                }

                try {
                    $url = 'https://news.google.com/rss/search?q=' .
                        urlencode($negara->nama_negara . ' ' . $queryBencana) .
                        '&hl=en-US&gl=US&ceid=US:en';

                    $response = Http::timeout(30)->retry(3, 2000)->get($url);
                    if ($response->failed()) {$gagal++; continue;}
                    $xml = simplexml_load_string($response->body());
                    if (!$xml || !isset($xml->channel->item)) {continue;}

                    foreach ($xml->channel->item as $item) {

                        $judul = (string) $item->title;
                        $link = (string) $item->link;
                        $tanggalPublikasi = Carbon::parse((string) $item->pubDate);

                        // ambil berita 24 jam terakhir
                        if ($tanggalPublikasi->lt(now()->subDay())) {
                            continue;
                        }

                        // Hitung skor negatif dari kata bencana
                        $skorNegatif = $this->hitungSkorNegatif($judul);
                        if ($skorNegatif == 0) {continue;}
                        $skorRisiko = $this->hitungSkorRisiko($skorNegatif);

                        DataBencana::updateOrCreate(
                            [
                                'url' => $link,
                            ],
                            [
                                'negara_id' => $negara->id,
                                'judul' => $judul,
                                'sumber' => 'Google News RSS',
                                'jenis_bencana' => $jenisBencana,
                                'skor_negatif' => $skorNegatif,
                                'skor_risiko_bencana' => $skorRisiko,
                                'tanggal_publikasi' => $tanggalPublikasi,
                            ]
                        );

                        $berhasil++;
                    }

                } catch (\Exception $e) {
                    $gagal++;
                    if ($output) {$output->error($e->getMessage());}
                }
                sleep(1);
            }
        }

        return [
            'berhasil' => $berhasil,
            'gagal' => $gagal,
        ];
    }

    // Hitung skor negatif berdasarkan kata yang ditemukan
    private function hitungSkorNegatif($teks)
    {
        $teks = strtolower($teks);
        $skor = 0;

        foreach ($this->kataNegatif as $kata => $bobot) {
            if (str_contains($teks, $kata)) {
                $skor += $bobot;
            }
        }

        return $skor;
    }

    // Konversi skor negatif menjadi tingkat risiko bencana
    private function hitungSkorRisiko($skorNegatif)
    {
        if ($skorNegatif >= 10) return 4; // Sangat tinggi
        if ($skorNegatif >= 7) return 3;  // Tinggi
        if ($skorNegatif >= 4) return 2;  // Sedang
        return 1; // Rendah
    }
}