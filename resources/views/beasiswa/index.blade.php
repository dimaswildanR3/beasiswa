@extends('layouts.master')
@section('content')
<section class="content card" style="padding: 10px 10px 20px 20px  ">
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
        <div class="row">
            <div class="col">
                <h4><i class="nav-icon fas fa-child my-0 btn-sm-1"></i> Master Beasiswa</h3>
                <hr>
            </div>
        </div>
        <div>
            <!--<div class="col">-->
            <!--    <a class="btn btn-primary btn-sm my-1 mr-sm-1" href="create" role="button"><i class="fas fa-plus"></i> Tambah Data</a>-->
            <!--    <br>-->
            <!--</div>-->
        </div>
        <div class="row">
            <div class="row table-responsive">
                <div class="col-12">
                    <table class="table table-hover table-head-fixed" id='tabelAgendaMasuk'>
                        <thead>
                            <tr class="bg-light">
                                <th>No.</th>
                                {{-- <th>NIS</th> --}}
                                <th><div style="width:110px;">Beasiswa</div></th>
                                {{-- <th><div style="width:110px;">alamat</div></th>
                                <th><div style="width:110px;">Jenis Kelamin</div></th> --}}
                                {{-- <th><center> Aksi</center></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            @foreach($datas as $beasiswa)
                            <?php $no++; ?>
                            <tr>
                                <td>{{$no}}</td>
                                {{-- <td>{{$beasiswa->nis}}</td> --}}
                                <td>{{$beasiswa->nama_beasiswa}}</td>
                                {{-- <td>{{$beasiswa->alamat}}</td>
                                <td>{{$beasiswa->jenis_kelamin}}</td> --}}
                                {{-- <td> --}}
                                    {{-- <center> --}}
                                    {{-- <div class="ok"style="width:220px;"> --}}
                                    {{-- <a href="/beasiswa/{{$beasiswa->id}}/edit" class="btn btn-primary btn-sm my-1 mr-sm-1"><i class="nav-icon fas fa-pencil-alt"></i> Edit</a> --}}
                                    {{-- @if (auth()->user()->role == 'admin') --}}
                                    <!--<a href="/beasiswa/{{$beasiswa->id}}/delete" class="btn btn-danger btn-sm my-1 mr-sm-1" onclick="return confirm('Hapus Data ?')"><i class="nav-icon fas fa-trash"></i>-->
                                    <!--    Hapus</a>-->
                                    {{-- <a href="/beasiswa/{{$beasiswa->id}}/show" class="btn btn-success btn-sm my-1 mr-sm-1"><i class="nav-icon fas fa-child"></i> Detail</a> --}}
                                    {{-- @endif --}}
                            
                                {{-- </div> --}}
                            {{-- </center> --}}
                                {{-- </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection