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
        <form action="/models/{{$Models->id}}/update" method="POST" enctype="multipart/form-data">
            <h4><i class="nav-icon fas fa-child my-1 btn-sm-1"></i> Edit Bobot</h4>
            <hr>
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <label for="nama">Beasiswa</label>
                    <select name="id_beasiswa" class="form-control my-1 mr-sm-2 bg-light" id="id_beasiswa" required>
                        <option value="">-- Pilih Beasiswa --</option>
                        @foreach($Beasiswa as $ayah)
                        <option value="{{$ayah->id}}" {{ $Models->id_beasiswa == $ayah->id ? 'selected' : '' }}>
                            {{$ayah->nama_beasiswa}}
                        </option>
                        @endforeach
                    </select>
                    
                    <label for="nama">Kriteria</label>
                    <select name="id_kriteria" class="form-control my-1 mr-sm-2 bg-light" id="id_kriteria" required>
                        <option value="">-- Pilih Kriteria --</option>
                        @foreach($Kriteria as $ibu)
                        <option value="{{$ibu->id}}" {{ $Models->id_kriteria == $ibu->id ? 'selected' : '' }}>
                            {{$ibu->nama}}
                        </option>
                        @endforeach
                    </select>
                    
                    <label for="bobot">Bobot</label>
                    <input value="{{ old('bobot', $Models->bobot) }}" 
                           name="bobot" type="number" class="form-control" id="bobot" 
                           placeholder="0" step="0.01" required 
                           oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" 
                           oninput="setCustomValidity('')">
                    
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> SIMPAN</button>
            <a class="btn btn-danger btn-sm" href="/models/index" role="button"><i class="fas fa-undo"></i> BATAL</a>
        </form>
    </div>
</section>
@endsection