<?php

namespace App\Http\Controllers;

use App\Kelas;
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
        public function getSiswa(Request $request)
        {
            $tahunAngkatan = $request->input('tahun_angkatan');
            $kelas = $request->input('kelas');
        
            // Query siswa berdasarkan tahun dan kelas
            $siswa = DB::table('siswa')
                ->where('tahun', $tahunAngkatan)
                ->where('kelas', $kelas)
                ->get();
        
            // Mengembalikan hasil dalam bentuk JSON
            return response()->json($siswa);
        }
    
        // public function __construct()
        // {
        //     $this->middleware('auth');
        // }
    
       
        

        public function filter(Request $request)
{
    $siswa = Siswa::where('tahun', $request->tahun)
                ->where('kelas', $request->kelas)
                ->get();
    return response()->json($siswa);
}

        public function index(Request $request)
        {
            // Ambil data filter dari request
            $tahun = $request->input('tahun');
            $kelasId = $request->input('kelas');
        
            // Ambil data tahun ajaran yang unik dari tabel siswa
            $tahunAjaran = Siswa::distinct()->pluck('tahun'); // Mengambil tahun ajaran yang unik
        
            // Ambil data kelas yang tersedia untuk dropdown
            $kelas = Kelas::all();
        
            // Query untuk mengambil data siswa dengan filter
            $datas = Siswa::when($tahun, function ($query) use ($tahun) {
                return $query->where('tahun', $tahun);
            })
            ->when($kelasId, function ($query) use ($kelasId) {
                return $query->where('kelas', $kelasId);
            })
            ->get();
        
            return view('siswa.index', compact('datas', 'tahunAjaran', 'kelas'));
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
            // Cek jika user memiliki level admin
            if (Auth::user()->level == 'admin') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
            }
        
            // Ambil data kelas dari database
            $kelas = Kelas::all();  // Mengambil semua data kelas
        
            // Pass data kelas ke view siswa.create
            return view('siswa.create', compact('kelas'));
        }
        
    
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        { $request->validate([
            'nis'  => 'required|unique:siswa,nis',
            'nama' => 'required|unique:siswa,nama',
        ]);
                $siswa = new Siswa;
                $siswa->nis             = $request->input('nis');
                $siswa->nama            = $request->input('nama');
                $siswa->alamat          = $request->input('alamat');
                // $siswa->penerbit        = $request->input('penerbit');
                $siswa->Jenis_kelamin   = $request->input('Jenis_kelamin');
             
                $siswa->tahun   = $request->input('tahun');      
                $siswa->kelas   = $request->input('kelas');      
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
            $kelas = Kelas::all();
            return view('siswa/edit', compact('siswa', 'kelas'));

        
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
            // $siswa->tanggungan   = $request->input('tanggungan');      
            // $siswa->penghasilan   = $request->input('penghasilan');      
            // $siswa->nilai   = $request->input('nilai');      
            // $siswa->jarak   = $request->input('jarak');      
            $siswa->tahun   = $request->input('tahun');      
            $siswa->kelas   = $request->input('kelas');      
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

        public function copyData()
        {
            // Ambil data tahun ajaran dan kelas yang tersedia
            $tahunAjaran = Siswa::distinct()->pluck('tahun'); // Ambil data tahun ajaran unik
            $kelas = Kelas::all(); // Ambil data kelas
    
            return view('siswa.copy', compact('tahunAjaran', 'kelas'));
        }
    
        // Menangani proses copy data berdasarkan tahun ajaran dan kelas
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
            $siswa = Siswa::where('tahun', $request->tahun)
                          ->where('kelas', $request->kelas)
                          ->get();
                          if ($siswa->isEmpty()) {
                            return back()->withErrors(['not_found' => 'Tidak ada data siswa untuk tahun dan kelas yang dipilih.']);
                        }
                    
    
            // Loop untuk menyalin data dan mengubah tahun dan kelas
            foreach ($siswa as $siswaItem) {
                // Buat salinan data siswa dengan tahun dan kelas baru
                Siswa::create([
                    'nis' => $siswaItem->nis,
                    'nama' => $siswaItem->nama,
                    'alamat' => $siswaItem->alamat,
                    'jenis_kelamin' => $siswaItem->jenis_kelamin,
                    'tahun' => $request->tahun_baru, // Ganti dengan tahun baru
                    'kelas' => $request->kelas_baru, // Ganti dengan kelas baru
                    // Tambahkan field lain jika diperlukan
                ]);
            }
    
            return redirect()->route('siswa')->with('sukses', 'Data berhasil disalin dengan tahun dan kelas baru!');
        }
    }