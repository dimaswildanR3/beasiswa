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
        <form action="/penilaian/store" method="POST" enctype="multipart/form-data">
            <h4><i class="nav-icon fas fa-child my-1 btn-sm-1"></i> Tambah Penilaian</h4>
            <hr>
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <label for="nama">Beasiswa</label>
                    <select name="id_model" class="form-control my-1 mr-sm-2 bg-light" id="id_model"  oninput="setCustomValidity('')">
                        <option value="">-- Pilih Beasiswa --</option>
                        @foreach($Model as $ayah)
                        <option value="{{$ayah->id}}"> {{$ayah->beasiswa->nama_beasiswa}} Kriteria {{$ayah->kriteria->nama}}
                        </option>
                        @endforeach
                    </select>       
                   
                        
                        <label for="keterangan">Nilai</label>
                        <table>
                            <tr>
                              <td>  <input value="{{old('keterangan')}}" name="keterangan" type="number" class="form-control" id="keterangan" placeholder="" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">    </td>
                              <td>-</td>
                              <td>  <input value="{{old('keterangan2')}}" name="keterangan2" type="number" class="form-control" id="keterangan2" placeholder="" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">     </td>
                            </tr>
                          </table>    
                    
                   
                    {{-- <label for="keterangan">Keterangan</label> --}}
                                
                    <label for="bobot">Bobot</label>
                    <input value="{{old('bobot')}}" name="bobot" type="number" class="form-control" id="bobot" placeholder="bobot" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">                   
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> SIMPAN</button>
            <a class="btn btn-danger btn-sm" href="index" role="button"><i class="fas fa-undo"></i> BATAL</a>
        </form>
    </div>
</section>
@endsection