@extends('layouts.master')

@section('content')
<section class="content card" style="padding: 10px 10px 20px 20px;">
    <div class="box">
        @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-check"></i> Sukses :</h5>
            {{ session('sukses') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-info"></i> Informasi :</h5>
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
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
                <h4><i class="nav-icon fas fa-child my-0 btn-sm-1"></i> Penilaian</h4>
                <hr>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <a class="btn btn-primary btn-sm" href="{{ route('pesyaratan.create') }}">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        </div>

        <div class="row table-responsive">
            <div class="col-12">
                <table class="table table-hover table-head-fixed" id="tabelAgendaMasuk">
                    <thead class="bg-light">
                        <tr>
                            <th>No.</th>
                            <th style="width:110px;">NIS</th>
                            <th style="width:110px;">Nama</th>
                            <th style="width:110px;">Beasiswa</th>
                            <th style="width:110px;">Kriteria</th>
                            <th style="width:110px;">Value</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datas as $index => $Penilaian)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $Penilaian->siswa->nis ?? '-' }}</td>
                            <td>{{ $Penilaian->siswa->nama ?? '-' }}</td>
                            <td>{{ $Penilaian->beasiswa->nama_beasiswa ?? '-' }}</td>
                            <td>{{ $Penilaian->kriteria->nama ?? '-' }}</td>
                            <td>{{ $Penilaian->nilai }}</td>
                            <td class="text-center">
                                <div style="width: 220px;">
                                    <!--<a href="{{ route('pesyaratan.edit', $Penilaian->id) }}" class="btn btn-primary btn-sm">-->
                                    <!--    <i class="nav-icon fas fa-pencil-alt"></i> Edit-->
                                    <!--</a>-->

                                    @if (auth()->user()->role == 'admin')
                                    <form action="{{ route('pesyaratan.destroy', $Penilaian->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus Data?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="nav-icon fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection
