@extends('layouts.master')

@section('content')
<section class="content card" style="padding: 10px 10px 20px 20px;">
    <div class="box">
        
        {{-- Success Message --}}
        @if(session('sukses'))
        <div class="callout callout-success alert alert-success alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-check"></i> Sukses:</h5>
            {{ session('sukses') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        
        {{-- Warning Message --}}
        @if(session('warning'))
        <div class="callout callout-warning alert alert-warning alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-info"></i> Informasi:</h5>
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        
        {{-- Error Messages --}}
        @if ($errors->any())
        <div class="callout callout-danger alert alert-danger alert-dismissible fade show">
            <h5><i class="fas fa-exclamation-triangle"></i> Peringatan:</h5>
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

        {{-- Title --}}
        <div class="row mb-3">
            <div class="col">
                <h4><i class="nav-icon fas fa-child my-0 btn-sm-1"></i> Biodata Siswa Tidak Aktif</h4>
                <hr>
            </div>
        </div>

      {{-- Add Data and Copy Data Button --}}
{{-- <div class="mb-3">
    <div class="d-flex">
        <a class="btn btn-primary btn-sm mr-2" href="create" role="button">
            <i class="fas fa-plus"></i> Tambah Data
        </a>
        <a class="btn btn-secondary  btn-sm" href="copy" role="button">
            <i class="fas fa-copy"></i> Copy Data
        </a>
    </div>
</div> --}}


        {{-- Filter Form --}}
        <div class="row">
            <div class="col">
                <form action="{{ route('siswa') }}" method="GET">
                    <div class="form-row align-items-end">
                        <!-- Filter Tahun Angkatan -->
                        <div class="col-sm-3 mb-3">
                            <label for="tahun">Tahun Angkatan</label>
                            <select class="form-control" name="tahun" id="tahun">
                                <option value="">Semua Tahun Angkatan</option>
                                @foreach($tahunAjaran as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tahun Angkatan -->
                        <div class="col-sm-3 mb-3">
                            <label for="tahun_pelajaran">Tahun Pelajaran</label>
                            <select class="form-control" name="tahun_pelajaran" id="tahun_pelajaran">
                                <option value="">Semua Tahun Pelajaran</option>
                                @foreach($tahunpelajaran as $tahunp)
                                    <option value="{{ $tahunp }}" {{ request('tahun_pelajaran') == $tahunp ? 'selected' : '' }}>{{ $tahunp }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- Filter Kelas -->
                        <div class="col-sm-3 mb-3">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" name="kelas" id="kelas">
                                <option value="">Semua Kelas</option>
                                @foreach($kelas as $kelasItem)
                                    <option value="{{ $kelasItem->id }}" {{ request('kelas') == $kelasItem->id ? 'selected' : '' }}>{{ $kelasItem->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- Button Submit Filter -->
                        <div class="col-sm-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-sm w-10" style="margin-top: 30px;">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        

        {{-- Data Table --}}
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover table-head-fixed" id="tabelAgendaMasuk">
                        <thead>
                            <tr class="bg-light">
                                <th>No.</th>
                                <th>NIS</th>
                                <th><div style="width: 110px;">Nama</div></th>
                                <th><div style="width: 110px;">Alamat</div></th>
                                <th><div style="width: 110px;">Jenis Kelamin</div></th>
                                <th><div style="width: 110px;">Tahun Angkatan</div></th>
                                <th><div style="width: 110px;">Tahun Pelajaran</div></th>
                                <th><div style="width: 110px;">Kelas</div></th>
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
                            @foreach($datas as $key => $siswa)
                            {{-- @php
                                var_dump($siswa);
                            @endphp --}}
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->alamat }}</td>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                                <td>{{ $siswa->tahun }}</td>
                                <td>{{$siswa->tahun_pelajaran }}</td>
                                

                                <td>{{ $siswa->Kelas->nama_kelas ?? 'kelas belum di isi' }}</td>
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
                                        <a href="/siswa/{{$siswa->id}}/edit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        @if (auth()->user()->role == 'admin')
                                        <a href="/siswa/{{$siswa->id}}/delete" class="btn btn-danger btn-sm" onclick="return confirm('Hapus Data ?')">
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
