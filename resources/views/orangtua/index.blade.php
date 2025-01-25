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
                <h4><i class="nav-icon fas fa-child my-0 btn-sm-1"></i> Data Orangtua</h4>
                <hr>
            </div>
        </div>

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
                                <th>Angkatan</th>
                                <th><div style="width: 110px;">Kelas</div></th>
                                <th><div style="width: 110px;">Jenis Kelamin</div></th>
                                <th><div style="width: 110px;">Penghasilan</div></th>
                                <th><div style="width: 110px;">Tanggungan</div></th>
                                <th><center>Aksi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orangtua as $key => $orangtuas)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $orangtuas->siswa->nis }}</td>
                                <td>{{ $orangtuas->nama }}</td>
                                <td>{{ $orangtuas->angkatan }}</td>
                                <td>{{ $orangtuas->Kelas->nama_kelas ?? 'kelas belum di isi' }}</td>
                                <td>{{ $orangtuas->jenis_kelamin }}</td>
                                <td>{{ $orangtuas->penghasilan }}</td>
                                <td>{{ $orangtuas->tanggungan }}</td>
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
