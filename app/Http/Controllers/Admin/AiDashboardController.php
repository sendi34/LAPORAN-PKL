<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiDashboardController extends Controller
{
    private $groqApiKey = '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';

    private $groqModel = 'llama-3.1-8b-instant';

    public function forecast(Request $request)
    {
        $lokasi_id = $request->query('lokasi_id');
        $parameter = $request->query('parameter');
        $tahun = $request->query('tahun', now()->year);

        $query = DB::table('hasil_uji')
            ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
            ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
            ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
            ->select(
                'observasi.tahun_pemantauan as tahun',
                'observasi.periode_pemantauan as periode',
                'indikator_uji.nama_indikator as parameter',
                'indikator_uji.satuan',
                DB::raw('ROUND(AVG(hasil_uji.nilai), 4)     as rata_nilai'),
                DB::raw('ROUND(AVG(hasil_uji.baku_mutu), 4) as baku_mutu')
            )
            ->where('observasi.tahun_pemantauan', '>=', $tahun - 4)
            ->groupBy('tahun', 'periode', 'parameter', 'satuan')
            ->orderBy('tahun')
            ->orderBy('periode');

        if ($lokasi_id) {
            $query->where('observasi.location_id', $lokasi_id);
        }
        if ($parameter) {
            $query->where('indikator_uji.nama_indikator', $parameter);
        }

        $historis = $query->get();

        if ($historis->isEmpty()) {
            return response()->json(['error' => 'Tidak ada data historis untuk filter ini.'], 404);
        }

        $namaLokasi = $lokasi_id
            ? DB::table('lokasi')->where('id', $lokasi_id)->value('alamat_lokasi') ?? 'Tidak diketahui'
            : 'Semua Lokasi';
        $tahunPrediksi = $tahun + 1;

        $prompt = "Kamu adalah sistem AI ahli analisis kualitas air laut untuk Provinsi Kalimantan Selatan, Indonesia.\n\n"
            ."DATA HISTORIS KUALITAS AIR (rata-rata per periode):\n"
            .json_encode($historis, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ."\n\nKonteks:\n"
            ."- Lokasi: {$namaLokasi}\n"
            .'- Parameter yang dianalisis: '.($parameter ?? 'Semua parameter')."\n"
            ."- Tahun prediksi: {$tahunPrediksi}\n\n"
            ."Tugasmu:\n"
            ."1. Analisis tren dari data historis\n"
            ."2. Prediksi nilai untuk Periode I dan Periode II tahun {$tahunPrediksi}\n"
            ."3. Tentukan status: Memenuhi Baku Mutu / Tercemar Ringan / Tercemar Sedang / Tercemar Berat\n"
            ."4. Berikan confidence level: Tinggi / Sedang / Rendah\n\n"
            ."PENTING: Jawab HANYA dengan JSON valid tanpa markdown, tanpa penjelasan di luar JSON.\n"
            ."Format JSON:\n"
            .'{"tren":"Membaik|Memburuk|Stabil|Fluktuatif","ringkasan":"narasi 2-3 kalimat","prediksi":[{"periode":"I","tahun":'.$tahunPrediksi.',"parameter":"nama","prediksi_nilai":0.00,"baku_mutu":0.00,"satuan":"...","prediksi_status":"..."},{"periode":"II","tahun":'.$tahunPrediksi.',"parameter":"nama","prediksi_nilai":0.00,"baku_mutu":0.00,"satuan":"...","prediksi_status":"..."}],"confidence":"Tinggi|Sedang|Rendah","alasan_confidence":"penjelasan singkat","faktor_risiko":["faktor 1","faktor 2"]}';

        $result = $this->callGroq($prompt);

        return response()->json($result);
    }

    public function correlation(Request $request)
    {
        $tahun = $request->query('tahun', now()->year);
        $lokasi_id = $request->query('lokasi_id');
        $periode = $request->query('periode');

        $query = DB::table('hasil_uji')
            ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
            ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
            ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
            ->select(
                'indikator_uji.nama_indikator as parameter',
                'indikator_uji.satuan',
                DB::raw('COUNT(hasil_uji.id) as total_data'),
                DB::raw('ROUND(AVG(hasil_uji.nilai), 4) as rata_nilai'),
                DB::raw('ROUND(MIN(hasil_uji.nilai), 4) as nilai_min'),
                DB::raw('ROUND(MAX(hasil_uji.nilai), 4) as nilai_max'),
                DB::raw('ROUND(AVG(hasil_uji.baku_mutu), 4) as baku_mutu'),
                DB::raw('COUNT(CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN 1 END) as n_melebihi'),
                DB::raw('ROUND(COUNT(CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN 1 END) * 100.0 / COUNT(hasil_uji.id), 2) as pct_melebihi'),
                DB::raw('ROUND(AVG(hasil_uji.nilai / NULLIF(hasil_uji.baku_mutu, 0)), 4) as rata_rasio')
            )
            ->where('observasi.tahun_pemantauan', $tahun);

        if ($lokasi_id) {
            $query->where('observasi.location_id', $lokasi_id);
        }
        if ($periode) {
            $query->where('observasi.periode_pemantauan', $periode);
        }

        $statParam = $query
            ->groupBy('indikator_uji.id', 'indikator_uji.nama_indikator', 'indikator_uji.satuan')
            ->orderByDesc('pct_melebihi')
            ->get();

        if ($statParam->isEmpty()) {
            return response()->json(['error' => 'Tidak ada data untuk tahun/filter ini.'], 404);
        }

        $namaLokasi = $lokasi_id
            ? DB::table('lokasi')->where('id', $lokasi_id)->value('alamat_lokasi') ?? 'Tidak diketahui'
            : 'Semua Lokasi';

        $prompt = "Kamu adalah analis lingkungan hidup ahli kualitas air laut Kalimantan Selatan, Indonesia.\n\n"
            ."STATISTIK PARAMETER KUALITAS AIR:\n"
            ."- Tahun: {$tahun}".($periode ? ", Periode {$periode}" : '')."\n"
            ."- Lokasi: {$namaLokasi}\n\n"
            .json_encode($statParam, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ."\n\nTugasmu:\n"
            ."1. Identifikasi parameter yang BERKORELASI berdasarkan ilmu lingkungan hidup\n"
            ."2. Temukan parameter early warning indicator\n"
            ."3. Analisis penyebab dominan pencemaran\n\n"
            ."PENTING: Jawab HANYA dengan JSON valid tanpa markdown.\n"
            .'Format JSON: {"ringkasan":"narasi","korelasi_kuat":[{"param_a":"...","param_b":"...","arah":"positif|negatif","kekuatan":"kuat|sedang|lemah","penjelasan":"..."}],"indikator_awal":[{"parameter":"...","alasan":"...","parameter_yang_terpengaruh":["..."]}],"penyebab_dominan":[{"penyebab":"...","parameter_terdampak":["..."],"tingkat_kepastian":"tinggi|sedang|rendah","rekomendasi_investigasi":"..."}],"parameter_kritis":["..."]}';

        $result = $this->callGroq($prompt);

        return response()->json($result);
    }

    public function recommend(Request $request)
    {
        $tahun = $request->query('tahun', now()->year);
        $periode = $request->query('periode');
        $lokasi_id = $request->query('lokasi_id');

        $query = DB::table('hasil_uji')
            ->join('observasi', 'hasil_uji.observasi_id', '=', 'observasi.id')
            ->join('lokasi', 'lokasi.id', '=', 'observasi.location_id')
            ->join('indikator_uji', 'indikator_uji.id', '=', 'hasil_uji.indikator_id')
            ->select(
                'lokasi.id as lokasi_id',
                'lokasi.kode_lokasi',
                'lokasi.alamat_lokasi',
                'lokasi.peruntukan',
                'indikator_uji.nama_indikator as parameter',
                DB::raw('ROUND(AVG(hasil_uji.nilai), 4) as rata_nilai'),
                DB::raw('ROUND(AVG(hasil_uji.baku_mutu), 4) as baku_mutu'),
                DB::raw('COUNT(CASE WHEN hasil_uji.nilai > hasil_uji.baku_mutu THEN 1 END) as n_melebihi'),
                DB::raw('COUNT(hasil_uji.id) as n_total')
            )
            ->where('observasi.tahun_pemantauan', $tahun);

        if ($periode) {
            $query->where('observasi.periode_pemantauan', $periode);
        }
        if ($lokasi_id) {
            $query->where('observasi.location_id', $lokasi_id);
        }

        $raw = $query
            ->groupBy('lokasi.id', 'lokasi.kode_lokasi', 'lokasi.alamat_lokasi', 'lokasi.peruntukan', 'indikator_uji.nama_indikator')
            ->get();

        if ($raw->isEmpty()) {
            return response()->json(['error' => 'Tidak ada data untuk filter ini.'], 404);
        }

        $perLokasi = $raw->groupBy('lokasi_id')->map(function ($rows) {
            $first = $rows->first();
            $paramBuruk = $rows
                ->filter(fn ($r) => $r->n_melebihi > 0)
                ->map(fn ($r) => [
                    'parameter' => $r->parameter,
                    'rata_nilai' => $r->rata_nilai,
                    'baku_mutu' => $r->baku_mutu,
                    'rasio' => $r->baku_mutu > 0 ? round($r->rata_nilai / $r->baku_mutu, 2) : null,
                    'pct_melebihi' => $r->n_total > 0 ? round($r->n_melebihi / $r->n_total * 100, 1) : 0,
                ])
                ->sortByDesc('rasio')
                ->values();

            $totalMelebihi = $rows->sum('n_melebihi');
            $totalData = $rows->sum('n_total');

            return [
                'kode_lokasi' => $first->kode_lokasi,
                'lokasi' => $first->alamat_lokasi,
                'peruntukan' => $first->peruntukan ?? 'Tidak diketahui',
                'total_parameter' => $rows->count(),
                'param_bermasalah' => $paramBuruk,
                'pct_pelanggaran' => $totalData > 0 ? round($totalMelebihi / $totalData * 100, 1) : 0,
            ];
        })->sortByDesc('pct_pelanggaran')->values();

        $prompt = "Kamu adalah konsultan lingkungan hidup senior ahli pengelolaan kualitas air laut di Kalimantan Selatan, Indonesia.\n\n"
            ."KONDISI KUALITAS AIR:\n"
            ."- Tahun: {$tahun}".($periode ? ", Periode {$periode}" : ', Semua Periode')."\n\n"
            .json_encode($perLokasi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            ."\n\nBuat Rencana Aksi Prioritas yang KONKRET dan SPESIFIK.\n\n"
            ."PENTING: Jawab HANYA dengan JSON valid tanpa markdown.\n"
            .'Format JSON: {"ringkasan_eksekutif":"narasi","prioritas_darurat":[{"lokasi":"...","tingkat_urgensi":"Kritis|Tinggi|Sedang","masalah_utama":"...","tindakan_segera":"...","instansi_terkait":["..."],"target_waktu":"..."}],"rekomendasi_jangka_panjang":[{"program":"...","lokasi_sasaran":["..."],"deskripsi":"...","estimasi_durasi":"...","indikator_keberhasilan":"..."}],"parameter_prioritas_monitoring":["..."],"lokasi_perlu_perhatian_khusus":["..."]}';

        $result = $this->callGroq($prompt);

        return response()->json($result);
    }

    private function callGroq(string $prompt): array
    {
        $url = 'https://api.groq.com/openai/v1/chat/completions';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->groqApiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post($url, [
                'model' => $this->groqModel,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Kamu adalah analis kualitas air laut ahli. Selalu jawab HANYA dengan JSON valid tanpa markdown, tanpa teks di luar JSON.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.3,
                'max_tokens' => 2048,
            ]);

            if ($response->failed()) {
                $errorBody = $response->json('error.message', 'Unknown error');
                Log::error('Groq API Error', ['status' => $response->status(), 'message' => $errorBody]);

                return ['error' => "Groq API gagal (HTTP {$response->status()}): {$errorBody}"];
            }

            $text = $response->json('choices.0.message.content', '');

            if (empty($text)) {
                return ['error' => 'Groq mengembalikan respons kosong.'];
            }

            // Bersihkan markdown fence jika ada
            $text = preg_replace('/```json\s*|\s*```/', '', $text);
            $text = preg_replace('/```\s*|\s*```/', '', $text);
            $decoded = json_decode(trim($text), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::warning('Groq JSON parse error', ['raw' => $text]);

                return [
                    'error' => 'Gagal mem-parse JSON dari Groq: '.json_last_error_msg(),
                    'raw' => substr($text, 0, 500),
                ];
            }

            return $decoded;

        } catch (\Exception $e) {
            Log::error('Groq Request Exception', ['message' => $e->getMessage()]);

            return ['error' => 'Exception: '.$e->getMessage()];
        }
    }
}
