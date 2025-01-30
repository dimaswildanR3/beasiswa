@extends('layouts.master')

@section('content')
<section class="content card" style="padding: 10px 10px 20px 20px;">
    <div class="box">
        
        <div class="row mb-3">
            <div class="col">
                <h4><i class="nav-icon fas fa-user-friends"></i> Biodata OrangTua</h4>
                <hr>
            </div>
        </div>
        {{-- Filter Form --}}
        <form action="{{ route('orangtua.index') }}" method="GET">z
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
            </div>
        </form>
        @php
        $allowedRoles = [
            'admin',
            'user_management',
            'tata_usaha',
            'wali_kelas',
          
            'kepala_sekolah',
           
        ];
    @endphp
    
    @if (in_array(auth()->user()->role, $allowedRoles))
          {{-- Add Data and Copy Data Button --}}
          <div class="mb-3">
            <div class="d-flex">
                <a class="btn btn-primary btn-sm mr-2" href="create" role="button">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
                <a class="btn btn-secondary  btn-sm" href="copy" role="button">
                    <i class="fas fa-copy"></i> Copy Data
                </a>
            </div>
        </div>
        @endif
        {{-- Data Table --}}
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover table-head-fixed" id="tabelAgendaMasuk">
                        <thead>
                            <tr class="bg-light">
                                <th>No.</th>
                                <th>NIS</th>
                                <th><div style="width: 150px;">Nama</div></th>
                                <th>Tahun Angkatan</th>
                                <th>Tahun Pelajaran</th>
                                <th><div style="width: 110px;">Kelas</div></th>
                                <th><div style="width: 110px;">Jenis Kelamin</div></th>
                                <th><div style="width: 110px;">Penghasilan</div></th>
                                <th><div style="width: 110px;">Tanggungan</div></th>
                                @php
                                $allowedRoles = [
                                    'admin',
                                    'user_management',
                                    'tata_usaha',
                                    'wali_kelas',
                                  
                                    'kepala_sekolah',
                                   
                                ];
                            @endphp
                            
                            @if (in_array(auth()->user()->role, $allowedRoles))
                                <th><center>Aksi</center></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orangtua as $key => $orangtuas)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $orangtuas->siswa->nis }}</td>
                                <td>{{ $orangtuas->nama }}</td>
                                <td>{{ $orangtuas->angkatan }}</td>
                                <td>{{ $orangtuas->tahun_pelajaran }}</td>
                                <td>{{ $orangtuas->Kelas->nama_kelas ?? 'kelas belum di isi' }}</td>
                                <td>{{ $orangtuas->jenis_kelamin }}</td>
                                <td>{{ $orangtuas->penghasilan }}</td>
                                <td>{{ $orangtuas->tanggungan }}</td>
                                @php
                                $allowedRoles = [
                                    'admin',
                                    'user_management',
                                    'tata_usaha',
                                    'wali_kelas',
                                  
                                    'kepala_sekolah',
                                   
                                ];
                            @endphp
                            
                            @if (in_array(auth()->user()->role, $allowedRoles))
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="/orangtua/{{$orangtuas->id}}/edit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        @if (auth()->user()->role == 'admin')
                                        <a href="/orangtua/{{$orangtuas->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Hapus Data ?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                @endif
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
