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
                <h4><i class="fas fa-book nav-icon my-0 btn-sm-1"></i> Biodata Nilai Pelajaran</h3>
                <hr>
            </div>
        </div>
        <div>
            <div class="col">
                <a class="btn btn-primary btn-sm my-1 mr-sm-1" href="create" role="button"><i class="fas fa-plus"></i> Tambah Data</a>
                <br>
            </div>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('nilaipelajaran.index') }}" method="GET">
            <div class="row mb-3">
                <div class="col">
                    <select name="tahun_angkatan" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih Tahun Angkatan</option>
                        @foreach($tahunAngkatan as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_angkatan') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select name="tahun_pelajaran" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih Tahun Pelajaran</option>
                        @foreach($tahunPelajaran as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun_pelajaran') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select name="kelas" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $kls)
                            <option value="{{ $kls->nama_kelas }}" {{ request('kelas') == $kls->nama_kelas ? 'selected' : '' }}>{{ $kls->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col">
                    <select name="semester" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih Semester</option>
                        @foreach($semesters as $smt)
                        <option value="{{ $smt }}" {{ request('semester') == $smt ? 'selected' : '' }}>{{ $smt }}</option>
                    @endforeach
                    </select>
                </div> --}}
            </div>
        </form>
        

        <div class="row">
            <div class="row table-responsive">
                <div class="col-12">
                    <table class="table table-hover table-head-fixed" id="tabelAgendaMasuk">
                        <thead>
                            <tr class="bg-light">
                                <th>No.</th>
                                <th>Nis</th>
                                <th>Nama</th>
                                <th>Tahun Angkatan</th>
                                <th>Tahun Pelajaran</th>
                                @foreach($kriteria as $k)
                                    <th>{{ $k->nama }}</th> <!-- Display subject name -->
                                @endforeach
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $nis => $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student['nis'] }}</td>
                                <td>{{ $student['nama'] }}</td>
                                <td>{{ $student['tahun_angkatan'] }}</td>
                                <td>{{ $student['tahun_pelajaran'] }}</td>
                                @foreach($kriteria as $k)
                                    <td>
                                        @if(isset($student[$k->id]))
                                            {{ $student[$k->id]['nilai'] }} <!-- Display grade -->
                                        @else
                                            N/A <!-- If no grade, show N/A -->
                                        @endif
                                    </td>
                                @endforeach
                                <td>{{ $student['kelas'] }}</td>
                                {{-- @php
                                    var_dump($student);
                                @endphp --}}
                                <td>
                                    <a href="{{ route('nilaipelajaran.edit', ['nis' => $nis, 'tahun_angkatan' => $student['tahun_angkatan'], 'tahun_pelajaran' => $student['tahun_pelajaran'], 'kelas' => $student['id_kelas']]) }}" class="btn btn-primary btn-sm">Edit</a>

                                    @php
                                    $allowedRoles = [
                                        'admin',
                                      
                                        'wali_kelas',
                                      
                                        'kepala_sekolah',
                                       
                                    ];
                                @endphp
                                
                                @if (in_array(auth()->user()->role, $allowedRoles))
                                    {{-- <a href="/nilaipelajaran/{{$nis}}/delete" class="btn btn-danger btn-sm">Delete</a> --}}
                                    <a href="{{ route('nilaipelajaran.destroy', ['nis' => $nis, 'tahun_angkatan' => $student['tahun_angkatan'], 'tahun_pelajaran' => $student['tahun_pelajaran'], 'kelas' => $student['id_kelas']]) }}" class="btn btn-danger btn-sm">Delete</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
