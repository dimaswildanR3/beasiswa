<?php

namespace App\Exports;


use App\Nilai;
use App\Kriteria;
use App\Models;  // Pastikan Models sudah di-import
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporandaftarExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
    $kriteria = Kriteria::with('model')->get();
        $maxValues = [];
        $minValues = [];

        // Mengambil nilai maksimum dan minimum berdasarkan sifat kriteria
        foreach ($kriteria as $k) {
            if ($k->sifat == 'Benefit') {
                $maxValues[$k->id] = Nilai::where('id_kriteria', $k->id)->max('nilai') ?? 0;
            } else {
                $minValues[$k->id] = Nilai::where('id_kriteria', $k->id)->min('nilai') ?? 0;
            }
        }

        // Ambil data siswa beserta nilainya
        $siswa = Nilai::with(['siswa', 'beasiswa', 'nilaipelajaran'])->where('id_beasiswa', 1)  // Tambahkan filter di sini
        ->get();

        // Proses perhitungan nilai preferensi (SAW)
        foreach ($siswa as $s) {
            $totalPreferensi = 0;

            // Perhitungan preferensi berdasarkan kriteria
            foreach ($kriteria as $k) {
                $nilai = Nilai::where('nis', $s->siswa->id)
                              ->where('id_kriteria', $k->id)
                              ->value('nilai') ?? 0;

                if ($k->sifat == 'Benefit') {
                    $normalizedValue = $maxValues[$k->id] != 0 ? $nilai / $maxValues[$k->id] : 0;
                } else {
                    $normalizedValue = $nilai != 0 ? $minValues[$k->id] / $nilai : 0;
                }

                $model = Models::where('id_kriteria', $k->id)->first();

                if ($model && isset($model->bobot)) {
                    $totalPreferensi += $normalizedValue * $model->bobot;
                }
            }

            $s->nilai_preferensi = $totalPreferensi;
        }

        // Urutkan berdasarkan nilai preferensi tertinggi
        $siswa = $siswa->sortByDesc('nilai_preferensi')->values();
// var_dump($siswa);
        // Mengembalikan data ke view
        return view('laporasseluruh/export_excel', [
            'siswa' => $siswa,   // Siswa yang sudah dihitung nilai preferensinya
        ]);
    }
}
