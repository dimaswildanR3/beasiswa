@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Laporan Beasiswa - Metode SAW</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
<<<<<<< HEAD

        <!-- Filter Tahun Masuk, Tahun Pelajaran, and Jenis Beasiswa -->
        <form method="GET" action="{{ route('perhitunganbeasiswa') }}">
            <div class="row">
                <div class="col-md-4">
                    <label for="tahun_masuk">Filter Tahun Masuk:</label>
                    <select name="tahun_masuk" id="tahun_masuk" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Pilih Tahun Masuk --</option>
                        @foreach($tahunMasukList as $t)
                            <option value="{{ $t }}" {{ request('tahun_masuk') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tahun_pelajaran">Filter Tahun Pelajaran:</label>
                    <select name="tahun_pelajaran" id="tahun_pelajaran" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Pilih Tahun Pelajaran --</option>
                        @foreach($tahunPelajaranList as $t)
                            <option value="{{ $t }}" {{ request('tahun_pelajaran') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="jenis_beasiswa">Filter Jenis Beasiswa:</label>
                    <select name="jenis_beasiswa" id="jenis_beasiswa" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Pilih Jenis Beasiswa --</option>
                        @foreach($jenisBeasiswaList as $beasiswa)
                            <option value="{{ $beasiswa }}" {{ request('jenis_beasiswa') == $beasiswa ? 'selected' : '' }}>{{ $beasiswa }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <br>

        @if(request('tahun_masuk') || request('tahun_pelajaran') || request('jenis_beasiswa'))
            <div class="alert alert-info">
                Menampilkan data untuk:
                @if(request('tahun_masuk')) 
                    Tahun Masuk <strong>{{ request('tahun_masuk') }}</strong> 
                @endif
                @if(request('tahun_pelajaran') && request('tahun_masuk'))
                    dan 
                @endif
                @if(request('tahun_pelajaran')) 
                    Tahun Pelajaran <strong>{{ request('tahun_pelajaran') }}</strong>
                @endif
                @if(request('jenis_beasiswa'))
                    dan Jenis Beasiswa <strong>{{ request('jenis_beasiswa') }}</strong>
                @endif
                . 
                <a href="{{ route('perhitunganbeasiswa') }}" class="btn btn-sm btn-warning">Reset</a>
            </div>
        @endif
        <div class="col">
            {{-- <button type="submit" class="btn btn-primary btn-sm my-1 mr-sm-1 "><i class="fas fa-print"></i> Cetak</button>             --}}
            <a class="btn btn-primary btn-sm my-1 mr-sm-1 " href="/perhitunganbeasiswa/export_excel" role="button"><i class="fas fa-file-excel"></i> Download Excel</a>
            {{-- <a class="btn btn-success btn-sm my-1 mr-sm-1 " href="index" role="button"><i class="fas fa-sync-alt"></i> Refresh</a> --}}
            {{-- <a class="btn btn-primary btn-sm my-1 mr-sm-1" href="create" role="button"><i class="fas fa-plus"></i> Tambah Data</a> --}}
            <br>
        </div>

=======
    @endif
    
    <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
>>>>>>> f83154f430c9230c7c57c8160760f58524c805c7
        <div class="row">
            <div class="col-md-4">
                <label for="tahun" class="form-label">Tahun</label>
                <select name="tahun" id="tahun" class="form-control">
    <option value="">Semua</option>
    @foreach ($tahunOptions as $tahunOption)
        <option value="{{ $tahunOption->tahun }}" {{ request('tahun') == $tahunOption->tahun ? 'selected' : '' }}>
            {{ $tahunOption->tahun }}
        </option>
    @endforeach
</select>

            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nilai SAW</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ number_format($item->nilai_saw, 2) }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
