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
        <form action="/penilaian/{{$Penilaian->id}}/update" method="POST" enctype="multipart/form-data">
            <h4><i class="nav-icon fas fa-child my-1 btn-sm-1"></i> Edit Penilaian</h4>
            <hr>
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <label for="nama">Beasiswa</label>
                    <select name="id_beasiswa" class="form-control my-1 mr-sm-2 bg-light" id="id_beasiswa"  oninput="setCustomValidity('')">
                        <option value="">-- Pilih Beasiswa --</option>
                        @foreach($Beasiswa as $ayah)
                        <option value="{{$ayah->id}}"> {{$ayah->nama_beasiswa}}
                        </option>
                        @endforeach
                    </select>
                    <label for="nama">Kriteria</label>
                    <select name="id_kriteria" class="form-control my-1 mr-sm-2 bg-light" id="id_kriteria"  oninput="setCustomValidity('')">
                        <option value="">-- Pilih Kriteria --</option>
                        @foreach($Kriteria as $ibu)
                        <option value="{{$ibu->id}}"> {{$ibu->nama}}
                        </option>
                        @endforeach
                    </select>
                    <label for="keterangan">Nilai</label>
                    <table>
                        <tr>
                          <td>  <input name="keterangan" type="text" class="form-control bg-light" id="keterangan" placeholder="Nama Rombel" value="{{$Penilaian->keterangan}}" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">   </td>
                          <td>-</td>
                          <td>  <input name="keterangan2" type="text" class="form-control bg-light" id="keterangan2" placeholder="Nama Rombel" value="{{$Penilaian->keterangan2}}" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')"></td>
                        </tr>
                      </table>    
                    {{-- <label for="keterangan">Keterangan</label>
                    <input name="keterangan" type="text" class="form-control bg-light" id="keterangan" placeholder="Nama Rombel" value="{{$Penilaian->keterangan}}" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')"> --}}
                    <label for="bobot">Bobot</label>
                    <input value="{{$Penilaian->bobot}}" name="bobot" type="text"step='0.01' class="form-control" id="bobot" placeholder="0.00" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">                   
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> SIMPAN</button>
            <a class="btn btn-danger btn-sm" href="/penilaian/index" role="button"><i class="fas fa-undo"></i> BATAL</a>
        </form>
    </div>
</section>
@endsection