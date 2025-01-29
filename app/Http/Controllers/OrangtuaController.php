<?php

namespace App\Http\Controllers;

use App\Approve;
use App\Kelas;
use App\Nilai;
use App\Orangtua;
use App\Siswa;
use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
    public function index(Request $request)
{
    $tahunAngkatan = Orangtua::distinct()->pluck('angkatan');
    $tahunPelajaran = Orangtua::distinct()->pluck('tahun_pelajaran');
    $kelas = Kelas::all();  // Mengambil semua data kelas

    $query = Orangtua::with(['siswa', 'kelas']);
    
    if ($request->has('tahun_angkatan') && $request->tahun_angkatan != '') {
        $query->where('angkatan', $request->tahun_angkatan);
    }
    
    if ($request->has('tahun_pelajaran') && $request->tahun_pelajaran != '') {
        $query->where('tahun_pelajaran', $request->tahun_pelajaran);
    }
    
    if ($request->has('kelas') && $request->kelas != '') {
        $query->whereHas('kelas', function ($q) use ($request) {
            $q->where('nama_kelas', $request->kelas);
        });
    }
    
    $orangtua = $query->get();
    
    return view('orangtua.index', compact('orangtua', 'tahunAngkatan', 'tahunPelajaran', 'kelas'));
}


    public function create()
    {
        $kelas = Kelas::all();
        $tahun = Siswa::select('tahun')->distinct()->get();
        $tahunajaran = Siswa::select('tahun_pelajaran')->distinct()->get();
        return view('orangtua.create', compact('kelas', 'tahun','tahunajaran'));
    }

    public function store(Request $request)
    {
        foreach ($request->orangtua as $siswa_id => $data) {
            // var_dump($data['tahun_pelajaran']);
            // die;
            $existingOrangtua = Orangtua::where('nis', $siswa_id)
            ->where('angkatan', $data['tahun'])
            ->first();

            if ($existingOrangtua) {
                // If record exists, return with an error message
                return back()->withErrors(['error' => 'Data Sudah ada']);
            }
            $Pesyaratan      = new Nilai();

            $penghasilan = $data['penghasilan'];
            $tanggungan = $data['tanggungan'];
            
            // Data Penghasilan
            $modelPenghasilan = \App\Penilaian::where('keterangan', '<=', $penghasilan)
            ->where('keterangan2', '>=', $penghasilan)
            ->where('id_kriteria', 4)
            ->first();
            if (!$modelPenghasilan) {
                // Jika modelPenghasilan tidak ditemukan
                return response()->json(['error' => 'Model Penghasilan tidak ditemukan untuk siswa ID: ' . $siswa_id.'tanggungan'.$penghasilan], 404);
            }

            $bobotmodel = \App\Models::where('id', $modelPenghasilan->id_model)->value('bobot');
            $sifat_penghasilan = \App\Kriteria::where('id', $modelPenghasilan->id_kriteria)->value('sifat');
            $max_bobot_penghasilan = \App\Penilaian::where('id_kriteria', $modelPenghasilan->id_kriteria)->max('bobot');
            $min_bobot = \App\Penilaian::where('id_kriteria', $modelPenghasilan->id_kriteria)->min('bobot');
            
            $hasilpenghasilan  = 0; // Inisialisasi variabel hasil
            
            if ($sifat_penghasilan == 'Benefit' && $max_bobot_penghasilan > 0) {
                $hasilpenghasilan  = $modelPenghasilan->bobot / $max_bobot_penghasilan;
            } elseif ($sifat_penghasilan == 'Cost' && $modelPenghasilan->bobot > 0) {
                $hasilpenghasilan  = $min_bobot / $modelPenghasilan->bobot;
            }
            $hasilpenghasilan  = number_format($hasilpenghasilan , 2);

            $nilaialhirpenghasilan=$hasilpenghasilan*$bobotmodel/100;
           
            $modelTanggungan = \App\Penilaian::where('keterangan', '<=', $tanggungan)
            ->where('keterangan2', '>=', $tanggungan)
            ->where('id_kriteria', 5)
            ->first();
        // var_dump( $modelTanggungan);
        // die;
                                             if (!$modelTanggungan) {
                                                // Jika modelTanggungan tidak ditemukan
                                                return response()->json(['error' => 'Model Tanggungan tidak ditemukan untuk siswa ID: ' . $siswa_id.$tanggungan], 404);
                                            }
            
            $bobotmodeltanggungan = \App\Models::where('id', $modelTanggungan->id_model)->value('bobot');
            $sifat_tanggungan = \App\Kriteria::where('id', $modelTanggungan->id_kriteria)->value('sifat');
            $max_bobot_tanggungan = \App\Penilaian::where('id_kriteria', $modelTanggungan->id_kriteria)->max('bobot');
            $min_bobot = \App\Penilaian::where('id_kriteria', $modelTanggungan->id_kriteria)->min('bobot');
            
            $hasiltanggungan  = 0; // Inisialisasi variabel hasil
            
            if ($sifat_tanggungan == 'Benefit' && $max_bobot_tanggungan > 0) {
                $hasiltanggungan  = $modelTanggungan->bobot / $max_bobot_tanggungan;
            } elseif ($sifat_tanggungan == 'Cost' && $modelTanggungan->bobot > 0) {
                $hasiltanggungan  = $min_bobot / $modelTanggungan->bobot;
            }
            $hasiltanggungan  = number_format($hasiltanggungan , 2);
            //    $Pesyaratan->id_beasiswa          = $model->id_beasiswa;
            //    $Pesyaratan->id_kriteria            = $model->id_kriteria;           
            $nilaialhirhasiltanggungan=$hasiltanggungan*$bobotmodeltanggungan/100;
            $NilaiPreferensi=$nilaialhirpenghasilan+$nilaialhirhasiltanggungan;
            
           $Siswa=\App\Siswa::where('id', $siswa_id)->first();
           if (!$Siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan dengan ID: ' . $siswa_id], 404);
        }
        //    var_dump($Siswa);
        //    die;
       // dd($Pesyaratan->jarak);
           $Pesyaratan->tahun   =  $Siswa->tahun;
           $Pesyaratan->nis   =  $siswa_id;
           $Pesyaratan->id_beasiswa   =  $modelTanggungan->id_beasiswa;
           $Pesyaratan->id_kriteria   =  $modelTanggungan->id_kriteria;
           $Pesyaratan->nilai   =  $NilaiPreferensi;
        
    //    var_dump($Pesyaratan);
    //    die;
           $Pesyaratan->save();
            // var_dump($data);
            // die;$aprove->tahun = $Siswa->tahun;
            $aprove = new Approve();
        $aprove->tahun   =  $Siswa->tahun;
        $aprove->nis = $siswa_id;
        $aprove->id_beasiswa = $modelTanggungan->id_beasiswa;
        $aprove->nilai = $NilaiPreferensi;
        $aprove->aksi = "Tambah Data";  // Menandakan aksi hapus
        $aprove->save();
            Orangtua::create([
                'nis' => $data['id'],
                'nama' => $data['nama_orangtua'],
                'tahun_pelajaran' => $data['tahun_pelajaran'],
                'angkatan' => $data['tahun'],
                'kelas_id' => $data['kelas'],
                'nama_orangtua' => $data['nama_orangtua'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'penghasilan' => $data['penghasilan'],
                'tanggungan' => $data['tanggungan'],
            ]);
        }

        return redirect()->route('orangtua.index')->with('sukses', 'Data orangtua berhasil disimpan.');
    }

    public function show($id)
    {
        $orangtua = Orangtua::with(['siswa', 'kelas'])->findOrFail($id);
        return view('orangtua.show', compact('orangtua'));
    }

    public function edit($id)
    {
        $kelas = Kelas::all();  // Mengambil semua data kelas
        $siswa = Siswa::where('aktif', 'Y')->get();
        // Mengambil semua data kelas

        $orangtua = Orangtua::findOrFail($id);
        return view('orangtua.edit', compact('orangtua','kelas','siswa'));
    }

    public function update(Request $request, $siswa_id)
    {
        $data = $request;
        // Cek apakah data sudah ada
        $existingOrangtua = Orangtua::find($siswa_id);
    // var_dump($existingOrangtua);
    // die;
        if (!$existingOrangtua) {
            return back()->withErrors(['error' => 'Data tidak ditemukan untuk diperbarui.']);
        }
        
        // Ambil model Nilai yang sudah ada atau buat baru jika tidak ada
        // var_dump($existingOrangtua->angkatan);
        // die;
        $Pesyaratan = Nilai::where('nis', $existingOrangtua->nis)
        ->where('tahun', $existingOrangtua->angkatan)
        ->where('id_beasiswa', 2)
        ->first();
    
        // Proses Penghasilan
        $penghasilan = $data['penghasilan'];
        $modelPenghasilan = \App\Penilaian::where('keterangan', '<=', $penghasilan)
            ->where('keterangan2', '>=', $penghasilan)
            ->where('id_kriteria', 4)
            ->first();
    
        if (!$modelPenghasilan) {
            return response()->json(['error' => 'Model Penghasilan tidak ditemukan untuk siswa ID: ' . $siswa_id], 404);
        }
    
        $bobotmodel = \App\Models::where('id', $modelPenghasilan->id_model)->value('bobot');
        $sifat_penghasilan = \App\Kriteria::where('id', $modelPenghasilan->id_kriteria)->value('sifat');
        $max_bobot_penghasilan = \App\Penilaian::where('id_kriteria', $modelPenghasilan->id_kriteria)->max('bobot');
        $min_bobot = \App\Penilaian::where('id_kriteria', $modelPenghasilan->id_kriteria)->min('bobot');
    
        $hasilpenghasilan = 0;
        if ($sifat_penghasilan == 'Benefit' && $max_bobot_penghasilan > 0) {
            $hasilpenghasilan = $modelPenghasilan->bobot / $max_bobot_penghasilan;
        } elseif ($sifat_penghasilan == 'Cost' && $modelPenghasilan->bobot > 0) {
            $hasilpenghasilan = $min_bobot / $modelPenghasilan->bobot;
        }
        $hasilpenghasilan = number_format($hasilpenghasilan, 2);
        $nilaialhirpenghasilan = $hasilpenghasilan * $bobotmodel / 100;
    
        // Proses Tanggungan
        $tanggungan = $data['tanggungan'];
        $modelTanggungan = \App\Penilaian::where('keterangan', '<=', $tanggungan)
            ->where('keterangan2', '>=', $tanggungan)
            ->where('id_kriteria', 5)
            ->first();
    
        if (!$modelTanggungan) {
            return response()->json(['error' => 'Model Tanggungan tidak ditemukan untuk siswa ID: ' . $existingOrangtua->nis], 404);
        }
    
        $bobotmodeltanggungan = \App\Models::where('id', $modelTanggungan->id_model)->value('bobot');
        $sifat_tanggungan = \App\Kriteria::where('id', $modelTanggungan->id_kriteria)->value('sifat');
        $max_bobot_tanggungan = \App\Penilaian::where('id_kriteria', $modelTanggungan->id_kriteria)->max('bobot');
        $min_bobot = \App\Penilaian::where('id_kriteria', $modelTanggungan->id_kriteria)->min('bobot');
    
        $hasiltanggungan = 0;
        if ($sifat_tanggungan == 'Benefit' && $max_bobot_tanggungan > 0) {
            $hasiltanggungan = $modelTanggungan->bobot / $max_bobot_tanggungan;
        } elseif ($sifat_tanggungan == 'Cost' && $modelTanggungan->bobot > 0) {
            $hasiltanggungan = $min_bobot / $modelTanggungan->bobot;
        }
        $hasiltanggungan = number_format($hasiltanggungan, 2);
        $nilaialhirhasiltanggungan = $hasiltanggungan * $bobotmodeltanggungan / 100;
    
        // Nilai Preferensi
        $NilaiPreferensi = $nilaialhirpenghasilan + $nilaialhirhasiltanggungan;
    
        // Ambil data siswa
        $Siswa = \App\Siswa::where('id', $existingOrangtua->nis)->first();
        if (!$Siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan dengan ID: ' . $existingOrangtua->nis], 404);
        }
    // var_dump($Pesyaratan);
    // die;
        // Update Data Nilai
        $Pesyaratan->tahun = $Siswa->tahun;
        $Pesyaratan->nis = $existingOrangtua->nis;
        $Pesyaratan->id_beasiswa = $modelTanggungan->id_beasiswa;
        $Pesyaratan->id_kriteria = $modelTanggungan->id_beasiswa;
        $Pesyaratan->nilai = $NilaiPreferensi;
        $Pesyaratan->save();
        $aprove = new Approve();
        $aprove->tahun = $Siswa->tahun;
        $aprove->nis = $existingOrangtua->nis;
        $aprove->id_beasiswa = $modelTanggungan->id_beasiswa;
        $aprove->nilai = $NilaiPreferensi;
        $aprove->aksi = "Update";  // Menandakan aksi hapus
        $aprove->save();
        // Update Data Orangtua
        $existingOrangtua->update([
            'nama' => $data['nama'],
            'tahun_pelajaran' => $Siswa->tahun_pelajaran,
            'angkatan' => $Siswa->tahun,
            'kelas_id' => $data['kelas_id'],
            'nama_orangtua' => $data['nama_orangtua'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'penghasilan' => $data['penghasilan'],
            'tanggungan' => $data['tanggungan'],
        ]);
    
        return redirect()->route('orangtua.index')->with('sukses', 'Data orangtua berhasil diperbarui.');
    }



    public function copyData()
    {
        // Ambil data tahun ajaran dan kelas yang tersedia
        $tahunAjaran = Orangtua::distinct()->pluck('angkatan'); // Ambil data tahun ajaran unik
        $kelas = Kelas::all(); // Ambil data kelas

        return view('orangtua.copy', compact('tahunAjaran', 'kelas'));
    }


    public function storeCopiedData(Request $request)
    {
        // Validasi input
        $request->validate([
            'tahun' => 'required',
            'kelas' => 'required',
            'tahun_baru' => 'required|different:tahun',  // Pastikan tahun_baru tidak sama dengan tahun
            'kelas_baru' => 'required',
        ], [
            'tahun_baru.different' => 'Tahun baru tidak boleh sama dengan tahun yang lama.',  // Pesan error custom
        ]);
        
        

        // Ambil data siswa berdasarkan tahun ajaran dan kelas yang dipilih
        $siswa = Orangtua::where('angkatan', $request->tahun)
                      ->where('kelas_id', $request->kelas)
                      ->get();
                      if ($siswa->isEmpty()) {
                        return back()->withErrors(['not_found' => 'Tidak ada data siswa untuk tahun dan kelas yang dipilih.']);
                    }
                

        // Loop untuk menyalin data dan mengubah tahun dan kelas
        foreach ($siswa as $siswaItem) {
            // Buat salinan data siswa dengan tahun dan kelas baru
            Orangtua::create([
                'nis' => $siswaItem->nis,
                'nama' => $siswaItem->nama,
                'jenis_kelamin' => $siswaItem->jenis_kelamin,
                'angkatan' => $request->tahun_baru, // Ganti dengan tahun baru
                'kelas' => $request->kelas_baru, // Ganti dengan kelas baru
                'penghasilan' => $siswaItem->penghasilan,
                'tanggungan' => $siswaItem->tanggungan,
                'tahun_pelajaran' => $siswaItem->tahun_pelajaran,
                // Tambahkan field lain jika diperlukan
            ]);
        }

        return redirect()->route('orangtua.index')->with('sukses', 'Data berhasil disalin dengan tahun dan kelas baru!');
    }
    
    

    public function destroy($id)
    {
        $orangtua = Orangtua::findOrFail($id);
        $Pesyaratan = Nilai::where('nis', $orangtua->nis)
        ->where('tahun', $orangtua->angkatan)
        ->where('id_beasiswa', 2)
        ->first();
        if ($Pesyaratan) {
            $Pesyaratan->delete();
        }
        $orangtua->delete();
     


        return redirect()->route('orangtua.index')->with('success', 'Data Orangtua berhasil dihapus');
    }
}
