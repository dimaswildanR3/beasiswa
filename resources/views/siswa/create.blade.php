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
        <form action="/siswa/store" method="POST" enctype="multipart/form-data">
            <h4><i class="nav-icon fas fa-child my-1 btn-sm-1"></i> Tambah Data Siswa</h4>
            <hr>
            {{csrf_field()}}
            <div class="row">

                <div class="col-md-12">
                    <label for="tahun">Tahun Angkatan</label>
                    <input value="{{old('tahun')}}" name="tahun" type="number" class="form-control" id="tahun" placeholder="Tahun Angkatan" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">
                </div>
                {{-- d --}}
                <br><br><br><br>
                <div class="col-md-6">
                    <label for="nama">Nama Siswa</label>
                    <input value="{{old('nama')}}" name="nama" type="text" class="form-control" id="nama" placeholder="Nama Siswa" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">
                    <label for="nis">Nis</label>
                    <input value="{{old('nis')}}" name="nis" type="number" class="form-control" id="nis" placeholder="Nis" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">
                    
                    <label for="alamat">Alamat</label>
                    <input value="{{old('alamat')}}" name="alamat" type="text" class="form-control" id="alamat" placeholder="Alamat" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">
                    <label for="Jenis_kelamin">Jenis Kelamin</label>
                    <select name="Jenis_kelamin" class="form-control my-1 mr-sm-1 bg-light" id="Jenis_kelamin" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-Laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                  
                    <label for="kelas">Kelas</label>
                    <select name="kelas" class="form-control" id="kelas" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    
                </div>
               
                <!--<div class="col-md-6">-->
                <!--    {{-- <div class="col-md-6"> --}}-->
                <!--        <label for="penghasilan">Penghasilan Orang Tua</label>-->
                <!--        <input value="{{old('penghasilan')}}" name="penghasilan" type="number" class="form-control" id="penghasilan" placeholder="Penghasilan Orang Tua" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">-->
                <!--        <label for="tanggungan">Tanggungan Orang Tua</label>-->
                <!--        <input value="{{old('tanggungan')}}" name="tanggungan" type="number" class="form-control" id="tanggungan" placeholder="Tanggungan Orang Tua" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">-->
         
                <!--        {{-- <label for="nilai">Nilai</label>-->
                <!--        <input value="{{old('nilai')}}" name="nilai" type="number" class="form-control" id="nilai" placeholder="Nilai" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')"> --}}-->
                <!--        {{-- <div class="col-sm-6">-->
                <!--        <label for="jarak">Jarak</label>-->
                <!--        <input value="{{old('jarak')}}" name="jarak" type="number" class="form-control" id="jarak" placeholder="Jarak" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">-->
                        
                <!--    </div> --}}-->
                <!--    </div>-->
                {{-- </div> --}}
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> SIMPAN</button>
            <a class="btn btn-danger btn-sm" href="index" role="button"><i class="fas fa-undo"></i> BATAL</a>
        </form>
    </div>
</section>
@endsection