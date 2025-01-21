<?php

namespace App\Exports;

use App\Nilai;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporansiswaExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
    //     $datas = TransaksiPerpus::all();
    
    // return view('/perpus/transaksi/index', compact('datas'));
        return view('laporansiswa/export_excel', [
            'datas' => Nilai::orderBy('tahun', 'desc')->get(),
            // 'total_transaksi' => TransaksiPerpus::all()->sum('jumlah_bayar'),
        ]);
    }
}
