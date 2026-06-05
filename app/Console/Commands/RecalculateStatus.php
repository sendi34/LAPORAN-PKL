<?php

namespace App\Console\Commands;

use App\Models\HasilUji;
use Illuminate\Console\Command;

class RecalculateStatus extends Command
{
    protected $signature = 'hasiluji:recalculate';

    protected $description = 'Hitung ulang status semua hasil uji';

    private array $parameterMinimum = [
        'dissolved oxygen', 'oksigen terlarut', 'do',
    ];

    public function handle()
    {
        $data = HasilUji::with('indikator')->get();
        $bar = $this->output->createProgressBar($data->count());
        $bar->start();

        foreach ($data as $hu) {
            if ($hu->baku_mutu === null || $hu->baku_mutu <= 0) {
                $bar->advance();

                continue;
            }

            $nama = strtolower($hu->indikator->nama_indikator ?? '');
            $isMinimum = collect($this->parameterMinimum)
                ->contains(fn ($k) => str_contains($nama, $k));

            $nilai = (float) $hu->nilai;
            $bakuMutu = (float) $hu->baku_mutu;

            if ($isMinimum) {
                if ($nilai >= $bakuMutu) {
                    $status = 'Memenuhi Baku Mutu';
                } elseif ($nilai >= $bakuMutu * 0.75) {
                    $status = 'Tercemar Ringan';
                } elseif ($nilai >= $bakuMutu * 0.50) {
                    $status = 'Tercemar Sedang';
                } else {
                    $status = 'Tercemar Berat';
                }
            } else {
                $rasio = $nilai / $bakuMutu;
                if ($rasio <= 1.0) {
                    $status = 'Memenuhi Baku Mutu';
                } elseif ($rasio <= 2.0) {
                    $status = 'Tercemar Ringan';
                } elseif ($rasio <= 5.0) {
                    $status = 'Tercemar Sedang';
                } else {
                    $status = 'Tercemar Berat';
                }
            }

            $hu->status = $status;
            $hu->save();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Selesai! Semua status berhasil dihitung ulang.');
    }
}
