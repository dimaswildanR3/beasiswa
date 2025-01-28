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
        <form action="/orangtua/{{$orangtua->id}}/update" method="POST" enctype="multipart/form-data">
            <h4><i class="nav-icon fas fa-child my-1 btn-sm-1"></i> Edit Data orangtua</h4>
            <hr>
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <label for="nis">Siswa</label>
                    <select name="nis" class="form-control" id="nis" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">
                        <option value="">Pilih Kelas</option>
                        @foreach($siswa as $ki)
                        {{-- @php
                            var_dump($kelas)
                        @endphp --}}
                            <option value="{{ $ki->id }}" {{ old('nis', $orangtua->nis) == $ki->id ? 'selected' : '' }}>
                                {{ $ki->nama.''.'('.'Tahun '.$ki->tahun.')' }}
                            </option>
                        @endforeach
                    </select>
                    
                    <label for="nama">Nama</label>
                    <input value="{{$orangtua->nama}}" name="nama" type="text" class="form-control" id="nama" placeholder="Nama" >
                    
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                        <option value="Laki-Laki" @if ($orangtua->jenis_kelamin == 'Laki-Laki') selected @endif>Laki-Laki</option>
                        <option value="Perempuan" @if ($orangtua->jenis_kelamin == 'Perempuan') selected @endif>Perempuan</option>
                    </select>                  
                    <label for="kelas_id">Kelas</label>
                    <select name="kelas_id" class="form-control" id="kelas_id" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k)
                        {{-- @php
                            var_dump($kelas)
                        @endphp --}}
                            <option value="{{ $k->id }}" {{ old('kelas_id', $orangtua->kelas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    <label for="penghasilan">Penghasilan</label>
                    <input value="{{$orangtua->penghasilan}}" name="penghasilan" type="number" class="form-control" id="penghasilan" placeholder="penghasilan" >
                    <label for="tanggungan">Tanggungan</label>
                    <input value="{{$orangtua->tanggungan}}" name="tanggungan" type="number" class="form-control" id="tanggungan" placeholder="tanggungan" >
                </div>

            <!--    <div class="col-md-6">-->
            <!--        <label for="tanggungan">Tanggungan Orang Tua</label>-->
            <!--        <input value="{{$orangtua->tanggungan}}" name="tanggungan" type="number" class="form-control" id="tanggungan" placeholder="tanggungan" >-->
            <!--        <label for="penghasilan">Penghasilan Orang Tua</label>-->
            <!--        <input value="{{$orangtua->penghasilan}}" name="penghasilan" type="number" class="form-control" id="penghasilan" placeholder="penghasilan" >-->
            <!--        <label for="tahun">Tahun Angkatan</label>-->
            <!--        <input value="{{$orangtua->tahun}}" name="tahun" type="number" class="form-control" id="tahun" placeholder="Tahun Angkatan" >-->
            <!--        {{-- <label for="nilai">Nilai</label>-->
            <!--        <input value="{{$orangtua->nilai}}" name="nilai" type="number" class="form-control" id="nilai" placeholder="nilai" > --}}-->
            <!--        {{-- <label for="jarak">Jarak</label>-->
            <!--        <input value="{{$orangtua->jarak}}" name="jarak" type="number" class="form-control" id="jarak" placeholder="jarak" > --}}-->

            <!--</div>-->
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> SIMPAN</button>
            <a class="btn btn-danger btn-sm" href="/orangtua/index" role="button"><i class="fas fa-undo"></i> BATAL</a>
        </form>
    </div>
</section>
@endsection