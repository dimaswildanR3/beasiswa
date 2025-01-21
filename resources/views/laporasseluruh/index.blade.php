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
                <h4><i class="nav-icon fas fa-child my-0 btn-sm-1"></i> Laporan Seluruh Siswa</h3>
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
            <div class="row table-responsive">
                <div class="col-12">
                    <table class="table table-hover table-head-fixed" id='tabelAgendaMasuk'>
                        <thead>
                            <tr class="bg-light">
                        {{-- <thead>
                            <tr class="bg-light"> --}}
                                {{-- <th>No.</th> --}}
                                <th>NIS</th>
                                <th><div style="width:110px;">Nama</div></th>
                                {{-- <th><div style="width:110px;">nilai</div></th> --}}
                                {{-- @foreach($Beasiswa as $siswaa)
                                <th><div style="width:110px;">{{$siswaa->nama_beasiswa}}</div></th>
                                @endforeach --}}
                                <th><div style="width:110px;">Total Perhitungan Bobotbeasiswa Kepala</div></th>
                                <th><div style="width:110px;">Total Perhitungan Bobotbeasiswa Yayasan</div></th>
                                <th><div style="width:110px;">Total Perhitungan Bobotbeasiswa Orang Tua Asuh</div></th>
                                {{-- <th><center> Aksi</center></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if ($datas && $datas->count() > 0) --}}
                            <?php $no = 0; ?>
                            @foreach($datas as $siswa)
                            <?php $no++; ?>
                            <tr>
                                {{-- <td>{{$no}}</td> --}}
                                <td>{{$siswa->siswa->nis}}</td>
                                <td>{{$siswa->siswa->nama}}</td>
                                <td>{{($siswa->nilai/DB::table('penilaian')->where('id_kriteria',"1")->count()*DB::table('model')->where('id',"1")->value('bobot'))+($siswa->nilai/DB::table('penilaian')->where('id_kriteria',"1")->count()*DB::table('model')->where('id',"2")->value('bobot'))+($siswa->nilai/DB::table('penilaian')->where('id_kriteria',"1")->count()*DB::table('model')->where('id',"3")->value('bobot'))}}</td>
                                <td>{{($siswa->nilai/DB::table('penilaian')->where('id_kriteria',"1")->count()*DB::table('model')->where('id',"10")->value('bobot'))+($siswa->nilai/DB::table('penilaian')->where('id_kriteria',"1")->count()*DB::table('model')->where('id',"10")->value('bobot'))+($siswa->nilai/DB::table('penilaian')->where('id_kriteria',"1")->count()*DB::table('model')->where('id',"10")->value('bobot'))}}</td>
                                <td>{{($siswa->nilai/DB::table('penilaian')->where('id_kriteria',"1")->count()*DB::table('model')->where('id',"10")->value('bobot'))+($siswa->nilai/DB::table('penilaian')->where('id_kriteria',"1")->count()*DB::table('model')->where('id',"10")->value('bobot'))+($siswa->nilai/DB::table('penilaian')->where('id_kriteria',"1")->count()*DB::table('model')->where('id',"40")->value('bobot'))}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- @else --}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection