<?php

namespace App\Http\Controllers;

use App\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PenilaianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        if(Auth::user()->level == 'admin') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $datas = \App\Penilaian::get();
        return view('penilaian.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level == 'admin') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }
        
        $Beasiswa = \App\Beasiswa::get();
        $Model = \App\Models::get();
        $Kriteria = \App\Kriteria::get();
        return view('penilaian.create', compact(['Kriteria','Beasiswa','Model','Beasiswa' => $Beasiswa,'Model' => $Model,'kriteria' => $Kriteria]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $Penilaian = new Penilaian;
            $Penilaian->id_model             = $request->input('id_model');
            $siswa = \App\Models::where('id', $request->input('id_model'))->first();
           
                $Penilaian     ->id_beasiswa          = $siswa->id_beasiswa;
                $Penilaian->id_kriteria            = $siswa->id_kriteria;
            
            // $Penilaian->id_beasiswa             = $request->input('id_beasiswa');
            $Penilaian->keterangan            = $request->input('keterangan');
            $Penilaian->keterangan2            = $request->input('keterangan2');
            $Penilaian->bobot          = $request->input('bobot');
            // $Penilaian->penerbit        = $request->input('penerbit');
            // $Penilaian->Jenis_kelamin   = $request->input('Jenis_kelamin');      
            $Penilaian->save();
        return redirect()->route('penilaian')->with('sukses', 'Data Penilaian Berhasil Ditambah');

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->level == 'admin') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/'); 
        }

        $data = Penilaian::findOrFail($id);

        return view('penilaian/show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {   
        if(Auth::user()->level == 'admin') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }
        $Penilaian = Penilaian::findOrFail($id);
        $Beasiswa = \App\Beasiswa::get();
        $Kriteria = \App\Kriteria::get();
        return view('penilaian/edit', compact(['Penilaian','Kriteria','Beasiswa','Beasiswa' => $Beasiswa,'kriteria' => $Kriteria]));

    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $Penilaian = Penilaian::where('id', $id)->first();
        $Penilaian->id_model             = $request->input('id_model');
        $siswa = \App\Models::where('id', $request->input('id_model'))->first();
        if($siswa){
            $Pesyaratan     ->id_beasiswa          = $siswa->id_beasiswa;
            $Penilaian->id_kriteria            = $siswa->id_kriteria;
        }
        // $Penilaian->id_beasiswa             = $request->input('id_beasiswa');
        $Penilaian->keterangan            = $request->input('keterangan');
        $Penilaian->keterangan2            = $request->input('keterangan2');
        $Penilaian->bobot          = $request->input('bobot');
        // $Penilaian->penerbit        = $request->input('penerbit');
        // $Penilaian->Jenis_kelamin   = $request->input('Jenis_kelamin');      
        $Penilaian->update();

        // $data->cover = $cover;
        // $data->save();


        // // alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('penilaian/index')->with('sukses', 'Data Penilaian Berhasil Diubah');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    
    {
        // Penilaian::findOrFail($id)->delete();
        // // alert()->success('Berhasil.','Data telah dihapus!');
        // return redirect()->route('penilaian')->with('sukses', 'Data Penilaian Berhasil Dihapus');

        try {
            $rombel = \App\Penilaian::find($id);
            $rombel->delete();
            return redirect('penilaian/index')->with('sukses', 'Data Rombongan Belajar Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('warning', 'Maaf data tidak dapat dihapus, masih terdapat data pada tabel lain yang terpaut dengan data ini!');
        }
    }
}

