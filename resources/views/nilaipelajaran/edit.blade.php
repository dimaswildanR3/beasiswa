@extends('layouts.master')

@section('content')
<section class="content card" style="padding: 10px 10px 10px 10px ">
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
        <form action="/nilaipelajaran/{{$nilaipelajaran->id}}/update" method="POST" enctype="multipart/form-data">
            <h4><i class="nav-icon fas fa-child my-1 btn-sm-1"></i> Edit Data Siswa</h4>
            <hr>
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <label for="nis">Nama</label>
                    <select name="nis" class="form-control" id="nis">
                        <option value="">-- Pilih Nama Siswa --</option>
                        @foreach ($siswa as $s)
                            <option value="{{ $s->id }}" {{ $nilaipelajaran->nis == $s->id ? 'selected' : '' }}>
                                {{ $s->nama }} ({{ $s->nis }})
                            </option>
                        @endforeach
                    </select>
                    <label for="nilai">Nilai</label>
                    <input value="{{$nilaipelajaran->nilai}}" name="nilai" type="number" class="form-control" id="nis" placeholder="nis" >
                    <label for="tahun_pelajaran">Tahun Pelajaran</label>
                    <input value="{{$nilaipelajaran->tahun_pelajaran}}" name="tahun_pelajaran" type="number" class="form-control" id="alamat" placeholder="alamat" >                   
                </div>             
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> SIMPAN</button>
            <a class="btn btn-danger btn-sm" href="/siswa/index" role="button"><i class="fas fa-undo"></i> BATAL</a>
        </form>
    </div>
</section>
@endsection