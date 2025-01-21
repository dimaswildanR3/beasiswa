<?php

namespace App\Http\Controllers;

use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporansiswaExport;
use App\Exports\LaporanbeasiswaExport;
use App\Exports\LaporandaftarExport;

class SiswaController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
    
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
    
            $datas = Siswa::orderBy('tahun', 'desc')->get();
            return view('siswa.index', compact('datas'));
        }
        
        public function indexxxx()
        {
            
            if(Auth::user()->level == 'admin') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
            // $cari = Siswa::where('tahun', $request->input('tahun'))
            $datas = Siswa::get();
            return view('laporanpendaftaran.index', compact('datas'));
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
    
            return view('siswa.create');
        }
    
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
                $siswa = new Siswa;
                $siswa->nis             = $request->input('nis');
                $siswa->nama            = $request->input('nama');
                $siswa->alamat          = $request->input('alamat');
                // $siswa->penerbit        = $request->input('penerbit');
                $siswa->Jenis_kelamin   = $request->input('Jenis_kelamin');
                $siswa->tanggungan   = $request->input('tanggungan');
                $siswa->penghasilan   = $request->input('penghasilan');      
                $siswa->nilai   = $request->input('nilai');      
                $siswa->jarak   = $request->input('jarak');      
                $siswa->tahun   = $request->input('tahun');      
                $siswa->save();
            return redirect()->route('siswa')->with('sukses', 'Data Siswa Berhasil Ditambah');
    
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
    
            $data = Siswa::findOrFail($id);
    
            return view('siswa/show', compact('data'));
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
            $siswa = Siswa::findOrFail($id);
        
            return view('siswa/edit', compact('siswa'));
    
        
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
            $siswa = Siswa::where('id', $id)->first();
            $siswa->nis             = $request->input('nis');
            $siswa->nama            = $request->input('nama');
            $siswa->alamat          = $request->input('alamat');
            // $siswa->penerbit        = $request->input('penerbit');
            $siswa->Jenis_kelamin   = $request->input('Jenis_kelamin');      
            $siswa->tanggungan   = $request->input('tanggungan');      
            $siswa->penghasilan   = $request->input('penghasilan');      
            $siswa->nilai   = $request->input('nilai');      
            $siswa->jarak   = $request->input('jarak');      
            $siswa->tahun   = $request->input('tahun');      
            $siswa->update();
    
            // $data->cover = $cover;
            // $data->save();
    
    
            // // alert()->success('Berhasil.','Data telah diubah!');
            return redirect()->to('siswa/index')->with('sukses', 'Data Siswa Berhasil Diubah');;
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
                $rombel = \App\Siswa::find($id);
                $rombel->delete();
                return redirect('siswa/index')->with('sukses', 'Data Rombongan Belajar Berhasil Dihapus');
            } catch (\Illuminate\Database\QueryException $ex) {
                return redirect()->back()->with('warning', 'Maaf data tidak dapat dihapus, masih terdapat data pada tabel lain yang terpaut dengan data ini!');
            }
          
        }
        public function export_excel()
        {
            return Excel::download(new LaporansiswaExport, 'laporansiswa.xlsx');
        }
        public function export_excelll()
        {
            return Excel::download(new LaporandaftarExport, 'laporanpendaftaran.xlsx');
        }
        public function export_excell()
        {
            return Excel::download(new LaporanbeasiswaExport, 'laporanbeasiswa.xlsx');
        }
    }