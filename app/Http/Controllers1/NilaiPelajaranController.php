<?php

namespace App\Http\Controllers;

use App\NilaiPelajaran;
use App\Siswa;
use Illuminate\Http\Request;

class NilaiPelajaranController extends Controller
{
    // Menampilkan daftar nilai pelajaran
    public function index()
    {
        $datas = NilaiPelajaran::with('siswa')->paginate(10);
        return view('nilaipelajaran.index', compact('datas'));
    }

    // Menampilkan form tambah data
    public function create()
    {
        $siswa =  Siswa::where('aktif','Y')->get();
        return view('nilaipelajaran.create', compact('siswa'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        // var_dump('test');
        // die;
        $request->validate([
            'nis' => 'required|exists:siswa,id',
            'nilai' => 'required|numeric',
            'tahun_pelajaran' => 'required|string|max:10'
        ], [
            'nis.required' => 'Siswa harus diisi.',
            'nis.exists' => 'Siswa yang dimasukkan tidak ditemukan.',
            'nilai.required' => 'Nilai harus diisi.',
            'nilai.numeric' => 'Nilai harus berupa angka.',
            'tahun_pelajaran.required' => 'Tahun Ajaran harus diisi.',
            'tahun_pelajaran.string' => 'Tahun Ajaran harus berupa teks.',
            'tahun_pelajaran.max' => 'Tahun Ajaran maksimal 10 karakter.'
        ]);
        
        NilaiPelajaran::create($request->all());

        return redirect()->route('nilaipelajaran.index')->with('success', 'Nilai berhasil ditambahkan');
    }

    // Menampilkan detail nilai pelajaran
    public function show($id)
    {
        $nilaipelajaran = NilaiPelajaran::with('siswa')->findOrFail($id);
        return view('nilaipelajaran.show', compact('nilaipelajaran'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $nilaipelajaran = NilaiPelajaran::findOrFail($id);
        $siswa =  Siswa::where('aktif','Y')->get();
        return view('nilaipelajaran.edit', compact('nilaipelajaran', 'siswa'));
    }

    // Menyimpan perubahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|exists:siswa,id',
            'nilai' => 'required|numeric',
            'tahun_pelajaran' => 'required|string|max:10'
        ], [
            'nis.required' => 'Siswa harus diisi.',
            'nis.exists' => 'Siswa yang dimasukkan tidak ditemukan.',
            'nilai.required' => 'Nilai harus diisi.',
            'nilai.numeric' => 'Nilai harus berupa angka.',
            'tahun_pelajaran.required' => 'Tahun Ajaran harus diisi.',
            'tahun_pelajaran.string' => 'Tahun Ajaran harus berupa teks.',
            'tahun_pelajaran.max' => 'Tahun Ajaran maksimal 10 karakter.'
        ]);
        

        $nilaipelajaran = NilaiPelajaran::findOrFail($id);
        $nilaipelajaran->update($request->all());

        return redirect()->route('nilaipelajaran.index')->with('success', 'Nilai berhasil diperbarui');
    }

    // Menghapus data
    public function destroy($id)
    {
        $nilaipelajaran = NilaiPelajaran::findOrFail($id);
        $nilaipelajaran->delete();

        return redirect()->route('nilaipelajaran.index')->with('success', 'Nilai berhasil dihapus');
    }
}
