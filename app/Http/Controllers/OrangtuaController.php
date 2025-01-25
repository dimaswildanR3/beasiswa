<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Orangtua;
use App\Siswa;
use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
    public function index()
    {
        $orangtua = Orangtua::with(['siswa', 'kelas'])->get();
        return view('orangtua.index', compact('orangtua'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $tahun = Siswa::select('tahun')->distinct()->get();
        return view('orangtua.create', compact('kelas', 'tahun'));
    }

    public function store(Request $request)
    {
        foreach ($request->orangtua as $siswa_id => $data) {
            // var_dump($data);
            // die;
            Orangtua::create([
                'nis' => $data['id'],
                'nama' => $data['nama'],
                'angkatan' => $data['tahun'],
                'kelas_id' => $data['kelas'],
                'nama_orangtua' => $data['nama_orangtua'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'penghasilan' => $data['penghasilan'],
                'tanggungan' => $data['tanggungan'],
            ]);
        }

        return redirect()->route('orangtua.index')->with('sukses', 'Data orangtua berhasil disimpan.');
    }

    public function show($id)
    {
        $orangtua = Orangtua::with(['siswa', 'kelas'])->findOrFail($id);
        return view('orangtua.show', compact('orangtua'));
    }

    public function edit($id)
    {
        $orangtua = Orangtua::findOrFail($id);
        return view('orangtua.edit', compact('orangtua'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|exists:siswa,id',
            'nama' => 'required|string|max:100',
            'angkatan' => 'required|integer',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|string',
            'penghasilan' => 'required|integer',
            'tanggungan' => 'required|integer'
        ]);

        $orangtua = Orangtua::findOrFail($id);
        $orangtua->update($request->all());

        return redirect()->route('orangtua.index')->with('success', 'Data Orangtua berhasil diperbarui');
    }

    public function destroy($id)
    {
        $orangtua = Orangtua::findOrFail($id);
        $orangtua->delete();

        return redirect()->route('orangtua.index')->with('success', 'Data Orangtua berhasil dihapus');
    }
}
