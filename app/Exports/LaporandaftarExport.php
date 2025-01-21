<?php

namespace App\Exports;

use App\Siswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporandaftarExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
    //     $datas = TransaksiPerpus::all();
    
    // return view('/perpus/transaksi/index', compact('datas'));
        return view('laporanpendaftaran/export_excel', [
            'datas' => Siswa::orderBy('tahun', 'desc')->get(),
            // 'total_transaksi' => TransaksiPerpus::all()->sum('jumlah_bayar'),
        ]);
    }
}
