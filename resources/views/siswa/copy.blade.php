<!-- resources/views/siswa/copy.blade.php -->

@extends('layouts.master')

@section('content')
<section class="content">
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
        <h4><i class="fas fa-copy"></i> Copy Data Siswa</h4>
        <form action="{{ route('siswa.storeCopy') }}" method="POST">
            @csrf
            <div class="form-row">
                <!-- Filter Tahun Ajaran (Untuk memilih data yang akan disalin) -->
                <div class="col-sm-3">
                    <label for="tahun">Tahun Ajaran</label>
                    <select class="form-control" name="tahun" id="tahun" required>
                        <option value="">Pilih Tahun Ajaran</option>
                        @foreach($tahunAjaran as $tahun)
                            <option value="{{ $tahun }}" {{ old('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Kelas (Untuk memilih data yang akan disalin) -->
                <div class="col-sm-3">
                    <label for="kelas">Kelas</label>
                    <select class="form-control" name="kelas" id="kelas" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $kelasItem)
                            <option value="{{ $kelasItem->id }}" {{ old('kelas') == $kelasItem->id ? 'selected' : '' }}>{{ $kelasItem->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun Ajaran Baru (Input manual) -->
                <div class="col-sm-3">
                    <label for="tahun_baru">Tahun Ajaran Baru</label>
                    <input type="number" class="form-control" name="tahun_baru" id="tahun_baru" value="{{ old('tahun_baru') }}" required>
                </div>

                <!-- Kelas Baru (Untuk input kelas baru setelah disalin) -->
                <div class="col-sm-3">
                    <label for="kelas_baru">Kelas Baru</label>
                    <select class="form-control" name="kelas_baru" id="kelas_baru" required>
                        <option value="">Pilih Kelas Baru</option>
                        @foreach($kelas as $kelasItem)
                            <option value="{{ $kelasItem->id }}" {{ old('kelas_baru') == $kelasItem->id ? 'selected' : '' }}>{{ $kelasItem->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Button Submit -->
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary btn-sm my-1" style="margin-top: 30px;">Copy Data</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
