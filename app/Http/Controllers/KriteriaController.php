<?php

namespace App\Http\Controllers;

use App\Kriteria;
use App\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
class KriteriaController extends Controller
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
        // $Beasiswa = \App\Beasiswa::get();
        $datas =  \App\Kriteria::get();
        return view('kriteria.index', compact('datas'));
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
        return view('kriteria.create',compact(['Beasiswa','Beasiswa' => $Beasiswa]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $kriteria = new Kriteria;
            $kriteria->id_beasiswa             = $request->input('id_beasiswa');
            $kriteria->nama            = $request->input('nama');
            $kriteria->sifat          = $request->input('sifat');
            // $kriteria->penerbit        = $request->input('penerbit');
            // $kriteria->Jenis_kelamin   = $request->input('Jenis_kelamin');      
            $kriteria->save();
        return redirect()->route('kriteria')->with('sukses', 'Data kriteria Berhasil Ditambah');

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

        $data = kriteria::findOrFail($id);

        return view('kriteria/show', compact('data'));
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
        $Beasiswa = \App\Beasiswa::get();
        $kriteria = kriteria::findOrFail($id);
    
        return view('kriteria/edit', compact(['kriteria','Beasiswa','Beasiswa' => $Beasiswa]));

    
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
        $kriteria = Kriteria::where('id', $id)->first();
        $kriteria->id_beasiswa             = $request->input('id_beasiswa');
        $kriteria->nama            = $request->input('nama');
        $kriteria->sifat          = $request->input('sifat');
        // $kriteria->penerbit        = $request->input('penerbit');
        // $kriteria->Jenis_kelamin   = $request->input('Jenis_kelamin');      
        $kriteria->update();

        // $data->cover = $cover;
        // $data->save();


        // // alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('kriteria/index')->with('sukses', 'Data kriteria Berhasil Diubah');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    
    {
        try {
            $rombel = \App\kriteria::find($id);
            $rombel->delete();
            return redirect('kriteria/index')->with('sukses', 'Data Rombongan Belajar Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('warning', 'Maaf data tidak dapat dihapus, masih terdapat data pada tabel lain yang terpaut dengan data ini!');
        }
        // kriteria::findOrFail($id)->delete();
        // // alert()->success('Berhasil.','Data telah dihapus!');
        // return redirect()->route('kriteria')->with('sukses', 'Data kriteria Berhasil Dihapus');
    }
}
