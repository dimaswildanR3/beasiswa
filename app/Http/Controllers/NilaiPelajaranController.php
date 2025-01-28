<?php

namespace App\Http\Controllers;

use App\Approve;
use App\Beasiswa;
use App\Kelas;
use App\Kriteria;
use App\Nilai;
use App\NilaiPelajaran;
use App\Siswa;
use Illuminate\Http\Request;

class NilaiPelajaranController extends Controller
{
    // Menampilkan daftar nilai pelajaran
    public function index(Request $request)
    {
        // Fetch distinct values for tahun angkatan, tahun pelajaran, kelas
        $tahunAngkatan = NilaiPelajaran::distinct()->pluck('tahun_angkatan');
        $tahunPelajaran = NilaiPelajaran::distinct()->pluck('tahun_pelajaran');
        $kelas = Kelas::all();
        $kriteria = Kriteria::where('id_beasiswa', 1)->get(); // Fetch kriteria yang sesuai
    
        // Start the query builder for NilaiPelajaran with the relationship 'siswa' and 'kriteria'
        $query = NilaiPelajaran::with(['siswa', 'kriteria', 'kelass']); // Include kriteria and kelass
        
        // Apply filters if present
        if ($request->has('tahun_angkatan') && $request->tahun_angkatan != '') {
            $query->where('tahun_angkatan', $request->tahun_angkatan);
        }
    
        if ($request->has('tahun_pelajaran') && $request->tahun_pelajaran != '') {
            $query->where('tahun_pelajaran', $request->tahun_pelajaran);
        }
    
        if ($request->has('kelas') && $request->kelas != '') {
            $query->whereHas('kelass', function ($q) use ($request) {
                $q->where('nama_kelas', $request->kelas);
            });
        }
    
        // Order the results
        $query->orderBy('nis', 'asc')->orderBy('tahun_angkatan', 'asc');
    
        // Get the filtered data
        $datas = $query->get();
    
        // Initialize an array to hold the students' data
        $students = [];
    
        // Loop through the results and organize the data
        foreach ($datas as $data) {
            // Ensure each student only appears once in the result
            if (!isset($students[$data->nis])) {
                $students[$data->nis] = [
                    'nis' => $data->siswa->nis,
                    'nama' => $data->siswa->nama,
                    'tahun_angkatan' => $data->tahun_angkatan,
                    'tahun_pelajaran' => $data->tahun_pelajaran,
                    'kelas' => $data->kelass->nama_kelas,
                    'id_kelas' => $data->kelass->id,
                ];
    
                // Initialize subject fields dynamically based on kriteria
                foreach ($kriteria as $k) {
                    $students[$data->nis][$k->id] = null; // Initialize as null for each subject
                }
            }
    
            // Assign grades dynamically based on kriteria id
            $students[$data->nis][$data->kriteria->id] = [
                'nama' => $data->kriteria->nama, // Subject name
                'nilai' => $data->nilai, // Grade
            ];
        }
    
        // Pass the data to the view
        return view('nilaipelajaran.index', compact('students', 'tahunAngkatan', 'tahunPelajaran', 'kelas', 'kriteria'));
    }
    
    
    

    // Menampilkan form tambah data
    public function create()
    {
        $siswa =  Siswa::where('aktif','Y')->get();
        $beasiswa = Beasiswa::where('id', 1)
    ->select('id', 'nama_beasiswa')
    ->first();
    // var_dump($beasiswa->id);
    // die;

        $kelas = Kelas::all();
        $kriteria = Kriteria::where('id_beasiswa',1)->get();
        $tahun = Siswa::select('tahun')->distinct()->get();
        $tahunajaran = Siswa::select('tahun_pelajaran')->distinct()->pluck('tahun_pelajaran');
        // var_dump($tahunajaran);
        // die;
        return view('nilaipelajaran.create', compact('siswa','kelas','tahun','tahunajaran','kriteria','beasiswa'));
    }

    // Menyimpan data baru
    public function store(Request $request)
{
    foreach ($request->orangtua as $nis => $orangtua_data) {
        // Validasi apakah siswa dengan NIS sudah ada
        $existingOrangtua = NilaiPelajaran::where('tahun_angkatan', $orangtua_data['tahun'])
            ->where('nis', $nis)
            // ->where('semester', $orangtua_data['semester'])
            ->first();
// var_dump($existingOrangtua);
// die;

        if ($existingOrangtua) {
            return back()->withErrors(['error' => 'Data Sudah ada']);
        }

        $firstValue = $request->nilai[$nis]; // Mengambil nilai dengan indeks 1
        // var_dump($firstValue[1]); // Akan menampilkan '3213'
        // die;
        
            // $Pesyaratan      = new Nilai();

            $Kerteria= Kriteria::where('id_beasiswa',$orangtua_data['beasiswa'])->pluck('id');
            // var_dump($Kerteria);
            // die;
            $hasilPenghasilanArray = []; // Array untuk menyimpan semua hasil

            foreach ($Kerteria as $kriteria_id) {
                $nilaikriteria = $firstValue[$kriteria_id];
                
                $nilai = \App\Penilaian::where('keterangan', '<=', $nilaikriteria)
                    ->where('keterangan2', '>=', $nilaikriteria)
                    ->where('id_kriteria', $kriteria_id)
                    ->first();
                
                if (!$nilai) {
                    // Jika modelPenghasilan tidak ditemukan
                    return response()->json(['error' => 'Model Penghasilan tidak ditemukan untuk siswa ID: ' . $nis . ' Nilai: ' . $nilaikriteria], 404);
                }
                
                $bobotmodel = \App\Models::where('id', $nilai->id_model)->value('bobot');
                $sifat_penghasilan = \App\Kriteria::where('id', $nilai->id_kriteria)->value('sifat');
                $max_bobot_penghasilan = \App\Penilaian::where('id_kriteria', $nilai->id_kriteria)->max('bobot');
                $min_bobot = \App\Penilaian::where('id_kriteria', $nilai->id_kriteria)->min('bobot');
                
                $hasilpenghasilan  = 0; // Inisialisasi variabel hasil
                
                if ($sifat_penghasilan == 'Benefit' && $max_bobot_penghasilan > 0) {
                    $hasilpenghasilan  = $nilai->bobot / $max_bobot_penghasilan;
                } elseif ($sifat_penghasilan == 'Cost' && $nilai->bobot > 0) {
                    $hasilpenghasilan  = $min_bobot / $nilai->bobot;
                }
                
                $hasilpenghasilan  = number_format($hasilpenghasilan, 2);
            
                $nilaialhirpenghasilan = $hasilpenghasilan * $bobotmodel / 100;
                
                // Menyimpan hasil per iterasi ke dalam array
                $hasilPenghasilanArray[] = $nilaialhirpenghasilan;
            }
            $totalHasilPenghasilan = array_sum($hasilPenghasilanArray);

            
            // Menampilkan semua hasil yang sudah diproses
            // var_dump($totalHasilPenghasilan);
            // die;
            
            // Data Penghasilan
            
            $Siswa=\App\Siswa::where('id', $nis)->first();
            if (!$Siswa) {
             return response()->json(['error' => 'Siswa tidak ditemukan dengan ID: ' . $nis], 404);
         }
           // Cek apakah sudah ada data dengan nis, tahun, dan id_beasiswa yang sama

// Jika tidak ada data, buat data baru
$Pesyaratan = new Nilai();
$Pesyaratan->tahun = $Siswa->tahun;
$Pesyaratan->nis = $nis;
$Pesyaratan->id_beasiswa = $nilai->id_beasiswa;
$Pesyaratan->id_kriteria = $nilai->id_beasiswa;
$Pesyaratan->nilai = $totalHasilPenghasilan;
// $Pesyaratan->semester = $orangtua_data['semester'];

$Pesyaratan->save();

$aprove = new Approve();
$aprove->tahun = $Siswa->tahun;
$aprove->nis = $nis;
$aprove->id_beasiswa = $nilai->id_beasiswa;
$aprove->id_kriteria = $nilai->id_beasiswa;
$aprove->nilai = $totalHasilPenghasilan;

$aprove->aksi = "Tambah Data";
// 'semester' => $orangtua_data['semester'], // Jika perlu, aktifkan
$aprove->save();



            
           
  
//     //    var_dump($Siswa);
//     //    die;
//    // dd($Pesyaratan->jarak);
//        $Pesyaratan->tahun   =  $Siswa->tahun;
//        $Pesyaratan->nis   =  $siswa_id;
//        $Pesyaratan->id_beasiswa   =  $modelTanggungan->id_beasiswa;
//        $Pesyaratan->id_kriteria   =  $modelTanggungan->id_beasiswa;
//        $Pesyaratan->nilai   =  $NilaiPreferensi;
 
//    var_dump($orangtua_data);
//    die;
//        $Pesyaratan->save();
    // 

        // Menyimpan nilai untuk tiap kriteria
        if (isset($request->nilai[$nis])) {
            foreach ($request->nilai[$nis] as $id_kriteria => $nilai) {
                // Validasi apakah beasiswa ada
              
                $id_beasiswa = $orangtua_data['beasiswa'];
                $beasiswa = \App\Beasiswa::find($id_beasiswa);
                if (!$beasiswa) {
                    return back()->withErrors(['error' => 'Beasiswa tidak ditemukan']);
                }

                // var_dump($orangtua_data['semester']);
                // die;
                // Insert data ke NilaiPelajaran
                NilaiPelajaran::create([
                    'nis' => $nis,
                    'id_beasiswa' => 1, // Data orangtua
                    'id_kriteria' => $id_kriteria, // Mengambil dari $orangtua_data['kriteria']
                    'tahun_angkatan' => $orangtua_data['tahun'], // Data orangtua
                    'tahun_pelajaran' => $orangtua_data['tahun_pelajaran'], // Data orangtua
                    'nilai' => $nilai, // Mengambil nilai dari data orangtua
                    'kelas' => $Siswa['kelas'], // Data orangtua
                    // 'semester' => $orangtua_data['semester'], // Data orangtua
                ]);
            }
        }
    }

    return redirect()->route('nilaipelajaran.index')->with('success', 'Nilai berhasil ditambahkan');
}

    // Menampilkan detail nilai pelajaran
    public function show($id)
    {
        $nilaipelajaran = NilaiPelajaran::with('siswa')->findOrFail($id);
        return view('nilaipelajaran.show', compact('nilaipelajaran'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        
        // $id_beasiswa = request('id_beasiswa');
        $tahun_angkatan = request('tahun_angkatan');
        $tahun_pelajaran = request('tahun_pelajaran');
        $kelas = request('kelas');
        // var_dump($tahun_angkatan);
        // die;
    
        $nilaipelajaran = NilaiPelajaran::where('nis', $id)
            // ->where('id_beasiswa', $id_beasiswa)
            ->where('tahun_angkatan', $tahun_angkatan)
            ->where('tahun_pelajaran', $tahun_pelajaran)
            ->where('kelas', $kelas)
            ->get();
    
        $siswa = Siswa::where('aktif', 'Y')
            ->where('tahun', $tahun_angkatan)
            ->where('nis', $id)
            ->where('tahun_pelajaran', $tahun_pelajaran)
            ->where('kelas', $kelas)
            ->get();
            // var_dump($nilaipelajaran);
            // die;
            $kriteria=Kriteria::where('id_beasiswa',1)->get();
    
        return view('nilaipelajaran.edit', compact('nilaipelajaran', 'siswa','kriteria'));
    }
    

    // Menyimpan perubahan
    public function update(Request $request)
    {
        // Iterasi melalui data orangtua untuk setiap siswa
        foreach ($request->orangtua as $nis => $orangtua_data) {
            
            // var_dump($orangtua_data['kelas']);
            // die;
            // Validasi apakah siswa dengan NIS sudah ada
            $existingOrangtua = NilaiPelajaran::where('tahun_angkatan', $orangtua_data['tahun'])
                ->where('nis', $nis)
                ->first();
    
            // Jika data sudah ada, bisa menambahkan error message
            // if ($existingOrangtua) {
            //     return back()->withErrors(['error' => 'Data Sudah ada']);
            // }
            
            // Ambil nilai berdasarkan NIS untuk proses lebih lanjut
            $firstValue = $request->nilai[$nis]; // Mengambil nilai dari request
    
            // Ambil kriteria berdasarkan ID beasiswa
            $Kerteria = Kriteria::where('id_beasiswa', $orangtua_data['beasiswa'])->pluck('id');
            
            // Array untuk menyimpan hasil per kriteria
            $hasilPenghasilanArray = []; 
    
            // Iterasi untuk setiap kriteria
            foreach ($Kerteria as $kriteria_id) {
                $nilaikriteria = $firstValue[$kriteria_id];
                
                // Ambil nilai berdasarkan keterangan dan kriteria
                $nilai = \App\Penilaian::where('keterangan', '<=', $nilaikriteria)
                    ->where('keterangan2', '>=', $nilaikriteria)
                    ->where('id_kriteria', $kriteria_id)
                    ->first();
                
                if (!$nilai) {
                    // Jika tidak ada nilai untuk kriteria
                    return response()->json(['error' => 'Model Penghasilan tidak ditemukan untuk siswa ID: ' . $nis . ' Nilai: ' . $nilaikriteria], 404);
                }
                
                // Ambil bobot dari model penilaian
                $bobotmodel = \App\Models::where('id', $nilai->id_model)->value('bobot');
                $sifat_penghasilan = \App\Kriteria::where('id', $nilai->id_kriteria)->value('sifat');
                $max_bobot_penghasilan = \App\Penilaian::where('id_kriteria', $nilai->id_kriteria)->max('bobot');
                $min_bobot = \App\Penilaian::where('id_kriteria', $nilai->id_kriteria)->min('bobot');
                
                $hasilpenghasilan = 0;
                
                // Kalkulasi hasil penghasilan berdasarkan sifat
                if ($sifat_penghasilan == 'Benefit' && $max_bobot_penghasilan > 0) {
                    $hasilpenghasilan = $nilai->bobot / $max_bobot_penghasilan;
                } elseif ($sifat_penghasilan == 'Cost' && $nilai->bobot > 0) {
                    $hasilpenghasilan = $min_bobot / $nilai->bobot;
                }
    
                // Format hasil penghasilan
                $hasilpenghasilan = number_format($hasilpenghasilan, 2);
    
                // Kalkulasi nilai akhir penghasilan
                $nilaialhirpenghasilan = $hasilpenghasilan * $bobotmodel / 100;
    
                // Simpan hasil penghasilan ke dalam array
                $hasilPenghasilanArray[] = $nilaialhirpenghasilan;
            }
    
            // Total hasil penghasilan
            $totalHasilPenghasilan = array_sum($hasilPenghasilanArray);
    
            // Cari data siswa berdasarkan NIS
            $Siswa = \App\Siswa::where('id', $nis)->first();
            if (!$Siswa) {
                return response()->json(['error' => 'Siswa tidak ditemukan dengan ID: ' . $nis], 404);
            }
    
            // Cek apakah sudah ada data dengan nis, tahun, dan id_beasiswa yang sama
            $Pesyaratan = Nilai::where('tahun', $Siswa->tahun)
                ->where('nis', $nis)
                ->where('id_beasiswa', $orangtua_data['beasiswa'])
                ->first();
    
            if ($Pesyaratan) {
                // Jika ada data, lakukan update
                $Pesyaratan->update([
                    'tahun' => $Siswa->tahun,
                    'nis' => $nis,
                    'id_beasiswa' => $orangtua_data['beasiswa'],
                    'id_kriteria' => $nilai->id_kriteria,
                    'nilai' => $totalHasilPenghasilan,
                    // 'semester' => $orangtua_data['semester'], // Jika perlu, aktifkan
                ]);
                $aprove = new Approve();
                $aprove->tahun = $Siswa->tahun;
                $aprove->nis = $nis;
                $aprove->id_beasiswa = $orangtua_data['beasiswa'];
                $aprove->id_kriteria = $nilai->id_kriteria;
                $aprove->nilai = $totalHasilPenghasilan;
                $aprove->aksi = "Update";
                // 'semester' => $orangtua_data['semester'], // Jika perlu, aktifkan
                $aprove->save();
        
            } else {
                // Jika data belum ada, buat data baru
                return response()->json(['error' => 'tidak tersimpan ke laporan' ], 404);
            }
    // var_dump( $orangtua_data['beasiswa']);
    // die;
    // $test=Approve::get();
    // var_dump($test);
    // die;
            // Simpan ke tabel Approve
           
            // Update nilai pelajaran berdasarkan kriteria
            foreach ($request->nilai[$nis] as $id_kriteria => $nilai) {
                // Validasi apakah beasiswa ada
                $id_beasiswa = $orangtua_data['beasiswa'];
                $beasiswa = \App\Beasiswa::find($id_beasiswa);
                if (!$beasiswa) {
                    return back()->withErrors(['error' => 'Beasiswa tidak ditemukan']);
                }
    
                // Cek apakah sudah ada data nilai pelajaran berdasarkan nis, kriteria, tahun_angkatan, dan tahun_pelajaran
                $nilaiPelajaran = NilaiPelajaran::where('nis', $nis)
                    ->where('id_kriteria', $id_kriteria)
                    ->where('tahun_angkatan', $orangtua_data['tahun'])
                    ->where('tahun_pelajaran', $orangtua_data['tahun_pelajaran'])
                    ->first();
    
                // Jika ditemukan, lakukan update
                if ($nilaiPelajaran) {
                    $nilaiPelajaran->update([
                        'nilai' => $nilai, // Update nilai
                        // 'semester' => $orangtua_data['semester'], // Jika perlu, aktifkan
                    ]);
                }
            }
        }
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('nilaipelajaran.index')->with('success', 'Nilai berhasil diperbarui');
    }
    

    // Menghapus data
    public function destroy($id)
    {
        // Mendapatkan parameter dari request
        $tahun_angkatan = request('tahun_angkatan');
        $tahun_pelajaran = request('tahun_pelajaran');
        $kelas = request('kelas');
    
        // Ambil data yang sesuai dengan tahun_angkatan, tahun_pelajaran, dan nis
        $existingOrangtua = NilaiPelajaran::where('tahun_angkatan', $tahun_angkatan)
            ->where('tahun_pelajaran', $tahun_pelajaran)
            ->where('nis', $id)
            ->get();  // Mengambil semua data yang sesuai
    
        // Cek apakah data ditemukan
        if ($existingOrangtua->isEmpty()) {
            return redirect()->route('nilaipelajaran.index')->withErrors('Data orangtua tidak ditemukan.');
        }
    
        // Ambil data Pesyaratan yang sesuai
        $Pesyaratan = Nilai::where('tahun', $tahun_angkatan)
            ->where('nis', $id)
            ->where('id_beasiswa', 1)
            ->first();
    
        // Cek apakah data Pesyaratan ditemukan
        if (!$Pesyaratan) {
            return redirect()->route('nilaipelajaran.index')->withErrors('Data Pesyaratan tidak ditemukan.');
        }
    
        // Menambahkan data ke tabel Approve
        $aprove = new Approve();
        $aprove->tahun = $tahun_angkatan;
        $aprove->nis = $id;
        $aprove->id_beasiswa = 1;
        $aprove->nilai = 0;  // Atur sesuai dengan nilai yang diperlukan
        $aprove->aksi = "Delete";  // Menandakan aksi hapus
        $aprove->save();  // Menyimpan record ke tabel Approve
    
        // Menghapus semua data yang ditemukan di $existingOrangtua
        foreach ($existingOrangtua as $orangtua) {
            $orangtua->delete();  // Menghapus masing-masing record
        }
    
        // Menghapus data Pesyaratan yang ditemukan
        $Pesyaratan->delete();
    
        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('nilaipelajaran.index')->with('success', 'Data berhasil dihapus');
    }
    
}
