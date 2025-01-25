@extends('layouts.master')

@section('content')
<section class="content card" style="padding: 10px 10px 10px 10px">
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

        <h4><i class="nav-icon fas fa-child my-1 btn-sm-1"></i> Siswa</h4>
        <hr>

        <!-- Data Table -->
        <table class="table table-hover table-head-fixed" id="tabelAgendaMasuk">
            <thead>
                <tr class="bg-light">
                    <th>No.</th>
                    <th>NIS</th>
                    <th><div style="width:110px;">Nama</div></th>
                    <th><div style="width:110px;">Alamat</div></th>
                    <th><div style="width:110px;">Jenis Kelamin</div></th>
                    <th><div style="width:110px;">Tahun Ajaran</div></th>
                    <th><div style="width:110px;">Kelas</div></th>
                    <th><center> Aksi</center></th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 0; ?>
                @foreach($datas as $siswa)
                <?php $no++; ?>
                <tr>
                    <td>{{$no}}</td>
                    <td>{{$siswa->nis}}</td>
                    <td>{{$siswa->nama}}</td>
                    <td>{{$siswa->alamat}}</td>
                    <td>{{$siswa->jenis_kelamin}}</td>
                    <td>{{$siswa->tahun}}</td>
                    <td>{{$siswa->Kelas->nama_kelas ?? 'kelas belum di isi'}}</td>
                    <td>
                        <div class="ok" style="width:220px;">
                            <a href="/siswa/{{$siswa->id}}/edit" class="btn btn-primary btn-sm my-1 mr-sm-1">
                                <i class="nav-icon fas fa-pencil-alt"></i> Edit
                            </a>
                            @if (auth()->user()->role == 'admin')
                            <a href="/siswa/{{$siswa->id}}/delete" class="btn btn-danger btn-sm my-1 mr-sm-1" onclick="return confirm('Hapus Data ?')">
                                <i class="nav-icon fas fa-trash"></i> Hapus
                            </a>
                            <a href="/siswa/{{$siswa->id}}/show" class="btn btn-success btn-sm my-1 mr-sm-1">
                                <i class="nav-icon fas fa-child"></i> Detail
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
