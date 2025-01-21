<?php

namespace App\Http\Controllers;

use App\Nilai;
use App\Beasiswa;
use App\Siswa;
use App\Penilaian;
use App\Kriteria;
use App\Exports\LaporanbeasiswaExport;
use App\Exports\LaporansiswaExport;
use App\Exports\LaporandaftarExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PesyaratanController extends Controller
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

        $datas = \App\Nilai::get();
        return view('Pesyaratan.index', compact('datas'));
    }
    public function indexxx()
    {
        
        if(Auth::user()->level == 'admin') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }
        // $cari = Siswa::where('tahun', $request->input('tahun'))
        $datas = Nilai::get();
        $Beasiswa = \App\Beasiswa::get();
        // if($datas){
        // $test = $datas->penghasilan - $datas->tanggungan;
        // }
        return view('perhitunganbeasiswa.index', compact(['Beasiswa','datas','Beasiswa' => $Beasiswa,'datas' => $datas]));
    }
    public function indexxs()
    {
    
        if(Auth::user()->level == 'admin') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }
        $Beasiswa = \App\Model::get();
        // $Siswa = \App\Siswa::get();
        $datas = \App\Nilai::get();
        
        return view('laporasseluruh.index', compact(['Beasiswa','datas','Beasiswa' => $Beasiswa,'datas' => $datas]));
    }
    public function carii(Request $request)
    {
        $cari = $request->cari;
        $Beasiswa = \App\Beasiswa::get();

        $datas = Siswa::where('tahun','like',"%".$cari."%")->paginate();

        return view('laporasseluruh.index', compact('datas', 'cari','Beasiswa'));
    }
    public function indexx()
        {
            
            if(Auth::user()->level == 'admin') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }

            $siswa = Siswa::get();
            $datas = Nilai::get();
           
//           
            // $cari = Siswa::where('tahun', $request->input('tahun'))
            $Beasiswa = \App\Beasiswa::get();
            return view('laporansiswa.index', compact(['Beasiswa','datas','Beasiswa' => $Beasiswa,'datas' => $datas]));
            // return view('laporansiswa.index', compact(['Beasiswa','datas','results','Beasiswa' => $Beasiswa,'results' => $results,'datas' => $datas]));
        }
        public function cari(Request $request)
        {
            $cari = $request->cari;
            $Beasiswa = \App\Beasiswa::get();
    
            $datas = Siswa::where('nama','like',"%".$cari."%")->paginate();
    
            return view('laporansiswa.index', compact('datas', 'cari','Beasiswa'));
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
        
        
        $Pesyaratan = \App\Nilai::get();
        $Siswa = \App\Siswa::get();
        $Model = \App\Models::get();
        // $Kriteria = \App\Kriteria::get();
        return view('pesyaratan.create', compact(['Pesyaratan','Model','Siswa','Pesyaratan' => $Pesyaratan,'Siswa' => $Siswa,'Model' => $Model,'Model' => $Model,]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $Pesyaratan      = new Nilai;

             $Pesyaratan->id_model             = $request->input('id_model');
            $model = \App\Models::where('id', $Pesyaratan->id_model)->first();
         
                $Pesyaratan->id_beasiswa          = $model->id_beasiswa;
                $Pesyaratan->id_kriteria            = $model->id_kriteria;
                
            // $Pesyaratan     ->keterangan            = $request->input('ketex rangan');
            $Pesyaratan->nis            = $request->input('nis');
            $siswa = \App\Siswa::where('id', $Pesyaratan->nis)->first();  

            $Kriteria = \App\Penilaian::where('id_kriteria',$Pesyaratan->id_kriteria)->get();  
            foreach ($Kriteria as $test){
               if($siswa->nilai >= $test->keterangan){
                $Pesyaratan->nilai = $test->bobot;
                // dd($Pesyaratan->nilai);
            }
            }
            foreach ($Kriteria as $testt){
               if($siswa->penghasilan >= $testt->keterangan){
                $Pesyaratan->penghasilan = $testt->bobot;
                // dd($Pesyaratan->penghasilan);
            }
            }
            foreach ($Kriteria as $testi){
               if($siswa->tanggungan >= $testi->keterangan){
                $Pesyaratan->tanggungan = $testi->bobot;
                // dd($Pesyaratan->tanggungan);
            }
            }
            foreach ($Kriteria as $ti){
               if($siswa->jarak >= $ti->keterangan){
                $Pesyaratan->jarak = $ti->bobot;
            }
        }
        // dd($Pesyaratan->jarak);
            $Pesyaratan->tahun   = $siswa->tahun;
         
        
            $Pesyaratan->save();
            
            return redirect()->route('pesyaratan')->with('sukses', 'Data Pesyaratan Berhasil Ditambah');
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

        $data = Pesyaratan      ::findOrFail($id);

        return view('Pesyaratan/show', compact('data'));
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
        $Penilaian = Nilai::findOrFail($id);
        $Beasiswa = \App\Beasiswa::get();
        $Kriteria = \App\Kriteria::get();
        $Siswa = \App\Siswa::get();
        $Model = \App\Models::get();
        return view('Pesyaratan/edit', compact(['Kriteria','Penilaian','Siswa','Beasiswa','Model','Model' => $Model,'Beasiswa' => $Beasiswa,'kriteria' => $Kriteria,'Siswa' => $Siswa]));

    
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
        $Pesyaratan      = Nilai::where('id', $id)->first();
        $Pesyaratan->id_model             = $request->input('id_model');
        $model = \App\Models::where('id', $Pesyaratan->id_model)->first();
     
            $Pesyaratan->id_beasiswa          = $model->id_beasiswa;
            $Pesyaratan->id_kriteria            = $model->id_kriteria;
            
        // $Pesyaratan     ->keterangan            = $request->input('ketex rangan');
        $Pesyaratan->nis            = $request->input('nis');
        $siswa = \App\Siswa::where('id', $Pesyaratan->nis)->first();  

        $Kriteria = \App\Penilaian::where('id_kriteria',$Pesyaratan->id_kriteria)->get();  
        foreach ($Kriteria as $test){
           if($siswa->nilai >= $test->keterangan){
            $Pesyaratan->nilai = $test->bobot;
            // dd($Pesyaratan->nilai);
        }
        }
        foreach ($Kriteria as $testt){
           if($siswa->penghasilan >= $testt->keterangan){
            $Pesyaratan->penghasilan = $testt->bobot;
            // dd($Pesyaratan->penghasilan);
        }
        }
        foreach ($Kriteria as $testi){
           if($siswa->tanggungan >= $testi->keterangan){
            $Pesyaratan->tanggungan = $testi->bobot;
            // dd($Pesyaratan->tanggungan);
        }
        }
        foreach ($Kriteria as $ti){
           if($siswa->jarak >= $ti->keterangan){
            $Pesyaratan->jarak = $ti->bobot;
        }
    }
    // dd($Pesyaratan->jarak);
        $Pesyaratan->tahun   = $siswa->tahun;
     
    
        
            // var_dump( $Pesyaratan     ->nilai );
        // $Pesyaratan      ->penerbit        = $request->input('penerbit');
        // $Pesyaratan      ->Jenis_kelamin   = $request->input('Jenis_kelamin');      
        $Pesyaratan     ->update();

        // $data->cover = $cover;
        // $data->save();


        // // alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('pesyaratan/index')->with('sukses', 'Data Pesyaratan Berhasil Diubah');;
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
            $rombel = \App\Nilai::find($id);
            $rombel->delete();
            return redirect('pesyaratan/index')->with('sukses', 'Data Rombongan Belajar Berhasil Dihapus');
        } catch (\Illuminate\Database\QueryException $ex) {
            return redirect()->back()->with('warning', 'Maaf data tidak dapat dihapus, masih terdapat data pada tabel lain yang terpaut dengan data ini!');
        }
       
    }
    // public function export_excel()
    //     {
    //         return Excel::download(new LaporansiswaExport, 'laporansiswa.xlsx');
    //     }
        public function export_excelll()
        {
            return Excel::download(new LaporandaftarExport, 'laporanpendaftaran.xlsx');
        }
        public function export_excell()
        {
            return Excel::download(new LaporanbeasiswaExport, 'laporanbeasiswa.xlsx');
        }
        public function export_excel()
        {
            return Excel::download(new LaporansiswaExport, 'laporansiswa.xlsx');
        }
}


