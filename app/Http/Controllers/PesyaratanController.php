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
        $Beasiswa = \App\Beasiswa::get();
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
    public function indexx(Request $request)
    {
        // Cek level user untuk memastikan hanya user selain admin yang dapat mengakses
        if (Auth::user()->level == 'admin') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }
    
        // Ambil data siswa dan nilai
        $siswa = Siswa::get();
        $datas = Nilai::get();
    
        // Ambil data Beasiswa
        $Beasiswa = \App\Beasiswa::get();
    
        // Cek apakah ada filter tahun yang dipilih dari form
        if ($request->has('tahun') && $request->tahun != '') {
            // Filter data siswa berdasarkan tahun
            $siswa = Siswa::where('tahun', $request->tahun)->get();
            $datas = Nilai::whereIn('nis', $siswa->pluck('nis'))->get(); // Mengambil nilai yang sesuai dengan siswa yang difilter berdasarkan tahun
        }
    
        // Kirimkan data ke view
        return view('laporansiswa.index', compact('Beasiswa', 'datas', 'siswa'));
    }
    
    public function cari(Request $request)
{
    // Ambil nilai cari dan tahun dari request
    $cari = $request->cari;
    $tahun = $request->tahun;
    
    // Ambil data Beasiswa dan Siswa
    $Beasiswa = \App\Beasiswa::get();
    $siswa = \App\Siswa::get();
    
    
    // Mulai query untuk mengambil data siswa
    $query = Nilai::query();
    // Filter berdasarkan nama jika ada input
    if ($cari) {
        $query->where('nis', $cari);
    }
    // var_dump($cari);
    // die;

    // Filter berdasarkan tahun jika ada input
    if ($tahun) {
        $query->whereYear('tahun', $tahun);  // Pastikan filter ini sesuai dengan field yang digunakan untuk tahun
    }

    // Ambil data siswa dengan paginasi
    $datas = $query->paginate();

    // Return ke view dengan data yang diperlukan
    return view('laporansiswa.index', compact('datas', 'cari', 'Beasiswa', 'tahun', 'siswa'));
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
        
        
        $nilaiajaran = \App\NilaiPelajaran::select('tahun_pelajaran')->distinct()->get();
        $Pesyaratan = \App\Nilai::get();
        $Siswa = \App\Siswa::get();
        $Model = \App\Models::get();
        // $Kriteria = \App\Kriteria::get();
        return view('pesyaratan.create', compact(['Pesyaratan','Model','Siswa','nilaiajaran','Pesyaratan' => $Pesyaratan,'Siswa' => $Siswa,'Model' => $Model,'Model' => $Model,]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_model' => 'required',
            'nis' => 'required',
            'nilaip' => 'required',
        ], [
            'id_model.required' => 'Beasiswa harus diisi.',
            'nis.required' => 'Siswa harus diisi.',
            'nilaip.required' => 'Tahun Ajaran harus diisi.',
        ]);
            $Pesyaratan      = new Nilai;

             $Pesyaratan->id_model             = $request->input('id_model');
            $model = \App\Models::where('id', $Pesyaratan->id_model)->first();
         
                $Pesyaratan->id_beasiswa          = $model->id_beasiswa;
                $Pesyaratan->id_kriteria            = $model->id_kriteria;
                
            // $Pesyaratan     ->keterangan            = $request->input('ketex rangan');
            $Pesyaratan->nis            = $request->input('nis');
            $siswa = \App\Siswa::where('id', $Pesyaratan->nis)->first();  
            $nilaip            = $request->input('nilaip');
            $nilaibro = \App\NilaiPelajaran::where('nis', $Pesyaratan->nis)
    ->where('tahun_pelajaran',  $nilaip)
    ->first();
    if (!$nilaibro) {
        return redirect()->back()->with('error', 'Nilai pelajaran tidak ditemukan untuk tahun ajaran yang dipilih.');
    }
            // var_dump($nilaibro->nilai);
            // die;
            $Kriteria = \App\Penilaian::where('id_kriteria',$Pesyaratan->id_kriteria)->get();  
            foreach ($Kriteria as $test){
               if($nilaibro->nilai >= $test->keterangan){
                $Pesyaratan->nilai = $test->bobot;
                // dd($Pesyaratan->nilai);
            }
            }
            foreach ($Kriteria as $testt){
               if($nilaibro->penghasilan >= $testt->keterangan){
                $siswa->penghasilan = $testt->bobot;
                // dd($Pesyaratan->penghasilan);
            }
            }
            foreach ($Kriteria as $testi){
               if($nilaibro->tanggungan >= $testi->keterangan){
                $siswa->tanggungan = $testi->bobot;
                // dd($Pesyaratan->tanggungan);
            }
            }
            foreach ($Kriteria as $ti){
               if($nilaibro->jarak >= $ti->keterangan){
                $Pesyaratan->jarak = $ti->bobot;
            }
        }
        // dd($Pesyaratan->jarak);
            $Pesyaratan->tahun   =  $nilaip;
         
        // var_dump($Pesyaratan);
        // die;
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
        $nilaiajaran = \App\NilaiPelajaran::select('tahun_pelajaran')->distinct()->get();
        $Penilaian = Nilai::findOrFail($id);
        $Beasiswa = \App\Beasiswa::get();
        $Kriteria = \App\Kriteria::get();
        $Siswa = \App\Siswa::get();
        $Model = \App\Models::get();
        return view('Pesyaratan/edit', compact(['Kriteria','Penilaian','Siswa','Beasiswa','Model','nilaiajaran','Model' => $Model,'Beasiswa' => $Beasiswa,'kriteria' => $Kriteria,'Siswa' => $Siswa]));

    
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
        $this->validate($request, [
            'id_model' => 'required',
            'nis' => 'required',
            'nilaip' => 'required',
        ], [
            'id_model.required' => 'Beasiswa harus diisi.',
            'nis.required' => 'Siswa harus diisi.',
            'nilaip.required' => 'Tahun Ajaran harus diisi.',
        ]);
        $Pesyaratan      = Nilai::where('id', $id)->first();
        $Pesyaratan->id_model             = $request->input('id_model');
        $model = \App\Models::where('id', $Pesyaratan->id_model)->first();
     
            $Pesyaratan->id_beasiswa          = $model->id_beasiswa;
            $Pesyaratan->id_kriteria            = $model->id_kriteria;
            
        // $Pesyaratan     ->keterangan            = $request->input('ketex rangan');
        $Pesyaratan->nis            = $request->input('nis');
        $siswa = \App\Siswa::where('id', $Pesyaratan->nis)->first();  
        $nilaip            = $request->input('nilaip');
        $nilaibro = \App\NilaiPelajaran::where('nis', $Pesyaratan->nis)
->where('tahun_pelajaran',  $nilaip)
->first();
if (!$nilaibro) {
    return redirect()->back()->with('error', 'Nilai pelajaran tidak ditemukan untuk tahun ajaran yang dipilih.');
}
        $Kriteria = \App\Penilaian::where('id_kriteria',$Pesyaratan->id_kriteria)->get();  
        foreach ($Kriteria as $test){
           if($nilaibro->nilai >= $test->keterangan){
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
        $Pesyaratan->tahun   = $nilaip;
     
    
        
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


