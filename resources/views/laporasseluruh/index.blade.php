@extends('layouts.master')
@section('content')
<section class="content card" style="padding: 10px 10px 20px 20px  ">
    <div class="box">
        @if(session('sukses'))
        <div class="callout callout-success alert alert-success alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-check"></i> Sukses :</h5>
            {{session('sukses')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('warning'))
        <div class="callout callout-warning alert alert-warning alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-info"></i> Informasi :</h5>
            {{session('warning')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if ($errors->any())
        <div class="callout callout-danger alert alert-danger alert-dismissible fade show">
            <h5><i class="fas fa-exclamation-triangle"></i> Peringatan :</h5>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="row">
            <div class="col">
                <h4><i class="nav-icon fas fa-child my-0 btn-sm-1"></i> Laporan Beasiswa Kurang Mampu (BKM)</h3>
                <hr>
            </div>
        </div>
        <div>
            <div>
                <form action="/laporasseluruh/index/cari" method="GET">
                    {{-- @csrf --}}
                    Tahun:
                    <input type="text" name="cari" class="form-control my-1 mr-sm-2 bg-light"value="{{ old('cari') }}" placeholder="Search...">
                    <input type="submit" class="btn btn-primary btn-sm my-1 mr-sm-1 "value="Tampilkan"style="margin-bottom:10px;">
                </form>
                {{-- <input type="text" name="" value="{{ $searchTerm ?? '' }}" placeholder="Search..."> --}}
          
            
            <div class="col">
                {{-- <button type="submit" class="btn btn-primary btn-sm my-1 mr-sm-1 "><i class="fas fa-print"></i> Cetak</button>             --}}
                <a class="btn btn-success btn-sm my-1 mr-sm-1 " href="/laporansiswa/export_excel" role="button"><i class="fas fa-file-excel"></i> Download Excel</a>
                {{-- <a class="btn btn-success btn-sm my-1 mr-sm-1 " href="index" role="button"><i class="fas fa-sync-alt"></i> Refresh</a> --}}
                {{-- <a class="btn btn-primary btn-sm my-1 mr-sm-1" href="create" role="button"><i class="fas fa-plus"></i> Tambah Data</a> --}}
                <br>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="bg-light">
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Tahun Angkatan</th>
                            <th>Nilai Preferensi</th>
                            {{-- <th>Beasiswa Yayasan</th>
                            <th>Beasiswa Orang Tua Asuh</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $siswa)
                        <tr>
                            <td>{{ $siswa->siswa->nis }}</td>
                            <td>{{ $siswa->siswa->nama }}</td>
                            <td>{{ $siswa->siswa->tahun }}</td>
                            <td>
                                {{ ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 1)->value('bobot')) +
                                   ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 2)->value('bobot')) +
                                   ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 3)->value('bobot')) }}
                            </td>
                            {{-- <td>
                                {{ ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) +
                                   ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) +
                                   ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) }}
                            </td>
                            <td>
                                {{ ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) +
                                   ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) +
                                   ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 40)->value('bobot')) }}
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection