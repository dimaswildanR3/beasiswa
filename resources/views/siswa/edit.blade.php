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
        <form action="/siswa/{{$siswa->id}}/update" method="POST" enctype="multipart/form-data">
            <h4><i class="nav-icon fas fa-child my-1 btn-sm-1"></i> Edit Data Siswa</h4>
            <hr>
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <label for="nis">Nis</label>
                    <input value="{{$siswa->nis}}" name="nis" type="number" class="form-control" id="nis" placeholder="nis" >
                    <label for="nama">Nama</label>
                    <input value="{{$siswa->nama}}" name="nama" type="text" class="form-control" id="nama" placeholder="Nama" >
                    <label for="alamat">Alamat</label>
                    <input value="{{$siswa->alamat}}" name="alamat" type="text" class="form-control" id="alamat" placeholder="alamat" >
                    <label for="Jenis_kelamin">Jenis Kelamin</label>
                    <select name="Jenis_kelamin" class="form-control" id="Jenis_kelamin" required>
                        <option value="Laki-Laki" @if ($siswa->Jenis_kelamin == 'Laki-Laki') selected @endif>Laki-Laki</option>
                        <option value="Perempuan" @if ($siswa->Jenis_kelamin == 'Perempuan') selected @endif>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="tanggungan">Tanggungan Orang Tua</label>
                    <input value="{{$siswa->tanggungan}}" name="tanggungan" type="number" class="form-control" id="tanggungan" placeholder="tanggungan" >
                    <label for="penghasilan">Penghasilan Orang Tua</label>
                    <input value="{{$siswa->penghasilan}}" name="penghasilan" type="number" class="form-control" id="penghasilan" placeholder="penghasilan" >
                    <label for="tahun">Tahun Mengajukan</label>
                    <input value="{{$siswa->tahun}}" name="tahun" type="number" class="form-control" id="tahun" placeholder="tahun" >
                    {{-- <label for="nilai">Nilai</label>
                    <input value="{{$siswa->nilai}}" name="nilai" type="number" class="form-control" id="nilai" placeholder="nilai" > --}}
                    <label for="jarak">Jarak</label>
                    <input value="{{$siswa->jarak}}" name="jarak" type="number" class="form-control" id="jarak" placeholder="jarak" >

            </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> SIMPAN</button>
            <a class="btn btn-danger btn-sm" href="/siswa/index" role="button"><i class="fas fa-undo"></i> BATAL</a>
        </form>
    </div>
</section>
@endsection