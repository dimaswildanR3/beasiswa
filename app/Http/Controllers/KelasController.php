<?php

namespace App\Http\Controllers;

use App\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil data kelas secara ascending berdasarkan 'nama_kelas'
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
    
        return view('kelas.index', compact('kelas'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|unique:kelas',
          
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
           
        ]);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('kelas.edit', compact('kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Temukan data berdasarkan ID
        $kela = Kelas::findOrFail($id);
    
        // Validasi input
        $request->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas,' . $kela->id,
            // 'tingkat' => 'required|integer',
            // 'wali_kelas' => 'required'
        ]);
    
        // Perbarui data kelas
        $kela->update([
            'nama_kelas' => $request->nama_kelas,
            // 'tingkat' => $request->tingkat,
            // 'wali_kelas' => $request->wali_kelas,
        ]);
    
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Temukan data berdasarkan ID
        $kela = Kelas::findOrFail($id);
    
        // Hapus data
        $kela->delete();
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
    
}
