<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Orangtua;
use App\Siswa;
use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
    public function index()
    {
        $orangtua = Orangtua::with(['siswa', 'kelas'])->get();
        return view('orangtua.index', compact('orangtua'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $tahun = Siswa::select('tahun')->distinct()->get();
        return view('orangtua.create', compact('kelas', 'tahun'));
    }

    public function store(Request $request)
    {
        foreach ($request->orangtua as $siswa_id => $data) {
            $existingOrangtua = Orangtua::where('nis', $data['id'])
            ->where('angkatan', $data['tahun'])
            ->first();

            if ($existingOrangtua) {
                // If record exists, return with an error message
                return back()->withErrors(['error' => 'Data ']);
            }
            $Pesyaratan      = new Nilai;

            
            $penghasilan =$data['penghasilan'];
           $model = \App\Penilaian::where('id', $Pesyaratan->id_model)->first();
        var_dump($penghasilan);
        die;
               $Pesyaratan->id_beasiswa          = $model->id_beasiswa;
               $Pesyaratan->id_kriteria            = $model->id_kriteria;
               
           // $Pesyaratan     ->keterangan            = $request->input('ketex rangan');
           $Pesyaratan->nis            = $request->input('nis');
           $siswa = \App\Siswa::where('id', $Pesyaratan->nis)->first();  
           $nilaip            = $request->input('nilaip');
           $nilaibro = $request->input('value');
   if (!$nilaibro) {
       return redirect()->back()->with('error', 'Nilai pelajaran tidak ditemukan untuk tahun ajaran yang dipilih.');
   }
           // var_dump($nilaibro->nilai);
           // die;
           $Kriteria = \App\Penilaian::where('id_kriteria',$Pesyaratan->id_kriteria)->get();  
           foreach ($Kriteria as $test){
              if($nilaibro >= $test->keterangan){
               $Pesyaratan->nilai = $test->bobot;
               // dd($Pesyaratan->nilai);
           }
           }
           foreach ($Kriteria as $testt){
              if($nilaibro >= $testt->keterangan){
               $siswa->penghasilan = $testt->bobot;
               // dd($Pesyaratan->penghasilan);
           }
           }
           foreach ($Kriteria as $testi){
              if($nilaibro >= $testi->keterangan){
               $siswa->tanggungan = $testi->bobot;
               // dd($Pesyaratan->tanggungan);
           }
           }
           foreach ($Kriteria as $ti){
              if($nilaibro >= $ti->keterangan){
               $Pesyaratan->jarak = $ti->bobot;
           }
       }
       // dd($Pesyaratan->jarak);
           $Pesyaratan->tahun   =  $nilaip;
        
       // var_dump($Pesyaratan);
       // die;
           $Pesyaratan->save();
            // var_dump($data);
            // die;
            Orangtua::create([
                'nis' => $data['id'],
                'nama' => $data['nama'],
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
        $orangtua = Orangtua::findOrFail($id);
        return view('orangtua.edit', compact('orangtua'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|exists:siswa,id',
            'nama' => 'required|string|max:100',
            'angkatan' => 'required|integer',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|string',
            'penghasilan' => 'required|integer',
            'tanggungan' => 'required|integer'
        ]);

        $orangtua = Orangtua::findOrFail($id);
        $orangtua->update($request->all());

        return redirect()->route('orangtua.index')->with('success', 'Data Orangtua berhasil diperbarui');
    }

    public function destroy($id)
    {
        $orangtua = Orangtua::findOrFail($id);
        $orangtua->delete();

        return redirect()->route('orangtua.index')->with('success', 'Data Orangtua berhasil dihapus');
    }
}
