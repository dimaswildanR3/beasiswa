<?php

namespace App\Http\Controllers;

use App\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class BeasiswaController extends Controller
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

        $datas = Beasiswa::get();
        return view('beasiswa.index', compact('datas'));
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

        return view('beasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $Beasiswa = new Beasiswa;
            $Beasiswa->nama_beasiswa             = $request->input('nama_beasiswa');
            // $Beasiswa->nama            = $request->input('nama');
            // $Beasiswa->alamat          = $request->input('alamat');
            // $Beasiswa->penerbit        = $request->input('penerbit');
            // $Beasiswa->Jenis_kelamin   = $request->input('Jenis_kelamin');      
            $Beasiswa->save();
        return redirect()->route('beasiswa')->with('sukses', 'Data Beasiswa Berhasil Ditambah');

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

        $data = Beasiswa::findOrFail($id);

        return view('beasiswa/show', compact('data'));
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
        $Beasiswa = Beasiswa::findOrFail($id);
    
        return view('beasiswa/edit', compact('Beasiswa'));

    
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
        $Beasiswa = Beasiswa::where('id', $id)->first();
        $Beasiswa->nama_beasiswa             = $request->input('nama_beasiswa');
        // $Beasiswa->nama            = $request->input('nama');
        // $Beasiswa->alamat          = $request->input('alamat');
        // $Beasiswa->penerbit        = $request->input('penerbit');
        // $Beasiswa->Jenis_kelamin   = $request->input('Jenis_kelamin');      
        $Beasiswa->update();

        // $data->cover = $cover;
        // $data->save();


        // // alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('beasiswa/index')->with('sukses', 'Data Beasiswa Berhasil Diubah');;
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
            $rombel = \App\Beasiswa::find($id);
            $rombel->delete();
            return redirect('rombel/index')->with('sukses', 'Data Rombongan Belajar Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('warning', 'Maaf data tidak dapat dihapus, masih terdapat data pada tabel lain yang terpaut dengan data ini!');
        }

        // Beasiswa::findOrFail($id)->delete();
        // // alert()->success('Berhasil.','Data telah dihapus!');
        // return redirect()->route('beasiswa')->with('sukses', 'Data Beasiswa Berhasil Dihapus');
    }
}
