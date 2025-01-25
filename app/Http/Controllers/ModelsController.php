<?php

namespace App\Http\Controllers;


use App\Models;
use App\Beasiswa;
use App\Kreteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ModelsController extends Controller
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

        $datas = \App\Models::get();
        return view('models.index', compact('datas'));
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
        $Kriteria = \App\Kriteria::get();
        return view('models.create', compact(['Kriteria','Beasiswa','Beasiswa' => $Beasiswa,'kriteria' => $Kriteria]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $Models = new Models;
            $Models->id_beasiswa             = $request->input('id_beasiswa');
            $Models->id_kriteria            = $request->input('id_kriteria');
            $Models->bobot          = $request->input('bobot');
            // $Models->penerbit        = $request->input('penerbit');
            // $Models->Jenis_kelamin   = $request->input('Jenis_kelamin');      
            $Models->save();
        return redirect()->route('models')->with('sukses', 'Data Models Berhasil Ditambah');

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

        $data = Models::findOrFail($id);

        return view('Models/show', compact('data'));
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
        $Models = Models::findOrFail($id);
        $Beasiswa = \App\Beasiswa::get();
        $Kriteria = \App\Kriteria::get();
        return view('models/edit', compact(['Models','Kriteria','Beasiswa','Beasiswa' => $Beasiswa,'kriteria' => $Kriteria]));

    
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
        $Models = Models::where('id', $id)->first();
        $Models->id_beasiswa             = $request->input('id_beasiswa');
        $Models->id_kriteria            = $request->input('id_kriteria');
        $Models->bobot          = $request->input('bobot');
        // $Models->penerbit        = $request->input('penerbit');
        // $Models->Jenis_kelamin   = $request->input('Jenis_kelamin');      
        $Models->update();

        // $data->cover = $cover;
        // $data->save();


        // // alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('models/index')->with('sukses', 'Data Models Berhasil Diubah');;
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
                $rombel = \App\Models::find($id);
                $rombel->delete();
                return redirect('models/index')->with('sukses', 'Data Rombongan Belajar Berhasil Dihapus');
            } catch (\Illuminate\Database\QueryException $ex) {
                return redirect()->back()->with('warning', 'Maaf data tidak dapat dihapus, masih terdapat data pada tabel lain yang terpaut dengan data ini!');
            }
    }
}
