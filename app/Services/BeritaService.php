<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Negara;
use App\Models\DataBerita;
use Carbon\Carbon;

class BeritaService
{
    public function updateBerita($output = null)
    {
        $kategoriList = [
            'logistik' => 'logistics',
            'perdagangan' => 'trade',
            'pelayaran' => 'shipping',
            'ekonomi' => 'economy',
        ];

        $semuaNegara = Negara::all();
        $berhasil = 0;
        $gagal = 0;

        foreach ($semuaNegara as $negara) {
            foreach ($kategoriList as $kategoriDb => $kategoriRss) {
                if ($output) {
                    $output->info("Mengambil berita {$negara->nama_negara} - {$kategoriDb}");
                }

                try {
                    // URL Google News RSS
                    $url = 'https://news.google.com/rss/search?q=' .
                        urlencode($negara->nama_negara . ' ' . $kategoriRss) .
                        '&hl=en-US&gl=US&ceid=US:en';

                    $response = Http::timeout(30)->get($url);
                    if ($response->failed()) {$gagal++; continue;}
                    // Parse XML RSS
                    $xml = simplexml_load_string($response->body());
                    if (!$xml || !isset($xml->channel->item)) {continue;}
                    foreach ($xml->channel->item as $item) {

                        $judul = (string) $item->title;
                        $link = (string) $item->link;
                        $tanggalPublikasi = Carbon::parse((string) $item->pubDate);

                        // Ambil berita dalam 24 jam terakhir
                        if ($tanggalPublikasi->lt(now()->subDay())) {
                            continue;
                        }

                        [$skorPositif, $skorNegatif, $sentimen] = $this->analisisSentimen($judul);
                        $skorRisiko = $this->hitungRisikoBerita($sentimen);
                        DataBerita::updateOrCreate(
                            [
                                'url' => $link,
                            ],
                            [
                                'negara_id' => $negara->id,
                                'judul' => $judul,
                                'deskripsi' => null,
                                'sumber' => 'Google News RSS',
                                'kategori' => $kategoriDb,
                                'skor_positif' => $skorPositif,
                                'skor_negatif' => $skorNegatif,
                                'sentimen' => $sentimen,
                                'skor_risiko_berita' => $skorRisiko,
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

    private function analisisSentimen($teks)
    {
        $teks = strtolower($teks);

        // Kata positif terkait ekonomi, perdagangan, logistik, dan pelayaran
        $kataPositif = [
            'growth', 'increase', 'profit', 'stable', 'improve',
            'success', 'strong', 'recovery', 'expand', 'expansion',
            'boost', 'surplus', 'gain', 'rise', 'record',
            'investment', 'investments', 'investor', 'cooperation',
            'partnership', 'agreement', 'deal', 'trade deal',
            'export growth', 'import growth', 'efficient', 'innovation',
            'development', 'progress', 'opportunity', 'positive',
            'resilient', 'capacity', 'modernization', 'upgrade',
            'sustainable', 'competitive', 'growth rate', 'improvement',
            'shipment growth', 'cargo growth', 'port expansion'
        ];

        // Kata negatif terkait ekonomi, perdagangan, logistik, pelayaran, dan geopolitik
        $kataNegatif = [
            'war', 'crisis', 'inflation', 'delay', 'disaster',
            'decline', 'loss', 'conflict', 'shortage', 'recession',
            'attack', 'strike', 'killed', 'death', 'violence',
            'tension', 'disruption', 'sanction', 'embargo',
            'collapse', 'bankruptcy', 'deficit', 'debt',
            'slowdown', 'risk', 'threat', 'damage', 'accident',
            'congestion', 'blockade', 'piracy', 'smuggling',
            'protest', 'unrest', 'instability', 'corruption',
            'fraud', 'cyberattack', 'outbreak', 'pandemic',
            'earthquake', 'flood', 'storm', 'hurricane',
            'drought', 'wildfire', 'explosion', 'shutdown',
            'cancellation', 'suspension', 'restriction', 'tariff',
            'trade war', 'economic crisis', 'shipping delay',
            'port closure', 'cargo shortage', 'fuel shortage'
        ];

        $skorPositif = 0;
        $skorNegatif = 0;

        // Hitung kata positif
        foreach ($kataPositif as $kata) {
            if (str_contains($teks, $kata)) {
                $skorPositif++;
            }
        }

        // Hitung kata negatif
        foreach ($kataNegatif as $kata) {
            if (str_contains($teks, $kata)) {
                $skorNegatif++;
            }
        }

        // Tentukan sentimen
        if ($skorPositif > $skorNegatif) {
            $sentimen = 'positif';
        } elseif ($skorNegatif > $skorPositif) {
            $sentimen = 'negatif';
        } else {
            $sentimen = 'netral';
        }

        return [$skorPositif, $skorNegatif, $sentimen];
    }

    private function hitungRisikoBerita($sentimen)
    {
        return match ($sentimen) {
            'negatif' => 3,
            'netral' => 2,
            'positif' => 1,
        };
    }
}