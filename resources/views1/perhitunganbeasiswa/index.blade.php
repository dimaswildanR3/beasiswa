@extends('layouts.master')

@section('content')
<section class="content card" style="padding: 10px 10px 20px 20px">
    <div class="box">
        @if(session('sukses'))
            <div class="callout callout-success alert alert-success alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-check"></i> Sukses :</h5>
                {{ session('sukses') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('warning'))
            <div class="callout callout-warning alert alert-warning alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-info"></i> Informasi :</h5>
                {{ session('warning') }}
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
                <h4><i class="nav-icon fas fa-child my-0 btn-sm-1"></i> Laporan Beasiswa</h4>
                <hr>
            </div>
        </div>

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

        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-hover table-head-fixed" id="tabelAgendaMasuk">
                    <thead>
                        <tr class="bg-light">
                            <th>NIS</th>
                            <th><div style="width:110px;">Nama</div></th>
                            <th><div style="width:110px;">Tahun</div></th>
                            <th>Nilai Preferensi</th>
                            {{-- <th>Total Perhitungan Bobot Beasiswa Yayasan</th>
                            <th>Total Perhitungan Bobot Beasiswa Orang Tua Asuh</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($siswa as $siswas)
                        <tr>
                            {{-- @php
                                var_dump($siswas);
                            @endphp --}}
                            <td>{{ $siswas->siswa->nis }}</td>
                            <td>{{ $siswas->siswa->nama }}</td>
                            <td>{{ $siswas->siswa->tahun }}</td>

                            <td>
                                @php
                                    $bobot_kepala = $siswas->nilai_preferensi;
                                @endphp
                                {{ $bobot_kepala }}
                            </td>
                            {{-- <td>
                                @php
                                    $bobot_yayasan = $siswas->nilai / (DB::table('penilaian')->where('id_kriteria', "14")->count() ?: 1) * DB::table('model')->where('id', "58")->value('bobot');
                                @endphp
                                {{ $bobot_yayasan }}
                            </td>
                            <td>
                                @php
                                    $bobot_orang_tua_asuh = $siswas->nilai / (DB::table('penilaian')->where('id_kriteria', "14")->count() ?: 1) * DB::table('model')->where('id', "58")->value('bobot');
                                @endphp
                                {{ $bobot_orang_tua_asuh }}
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
