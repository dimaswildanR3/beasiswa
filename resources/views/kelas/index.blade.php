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
                <h4><i class="nav-icon fas fa-child my-0 btn-sm-1"></i>Biodata kelas</h3>
                <hr>
            </div>
        </div>
        <div>
            @php
    $allowedRoles = [
        'admin',
        'user_management',
        'tata_usaha',
        'wali_kelas',
      
        'kepala_sekolah',
       
    ];
@endphp

@if (in_array(auth()->user()->role, $allowedRoles))

            <div class="col">
                <a class="btn btn-primary btn-sm my-1 mr-sm-1" href="create" role="button"><i class="fas fa-plus"></i> Tambah Data</a>
                <br>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="row table-responsive">
                <div class="col-12">
                    <table class="table table-hover table-head-fixed" id='tabelAgendaMasuk'>
                        <thead>
                            <tr class="bg-light">
                                <th>No.</th>
                                {{-- <th>NIS</th> --}}
                                <th><div style="width:110px;">kelas</div></th>
                                {{-- <th><div style="width:110px;">alamat</div></th>
                                <th><div style="width:110px;">Jenis Kelamin</div></th> --}}
                                @php
                                $allowedRoles = [
                                    'admin',
                                    'user_management',
                                    'tata_usaha',
                                    'wali_kelas',
                                  
                                    'kepala_sekolah',
                                   
                                ];
                            @endphp
                            
                            @if (in_array(auth()->user()->role, $allowedRoles))
                                <th><center> Aksi</center></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            @foreach($kelas as $kela)
                            <?php $no++; ?>
                            <tr>
                                <td>{{$no}}</td>
                                {{-- <td>{{$kelas->nis}}</td> --}}
                                <td>{{$kela->nama_kelas}}</td>
                                {{-- <td>{{$kelas->alamat}}</td>
                                <td>{{$kelas->jenis_kelamin}}</td> --}}
                                @php
                                $allowedRoles = [
                                    'admin',
                                    'user_management',
                                    'tata_usaha',
                                    'wali_kelas',
                                  
                                    'kepala_sekolah',
                                   
                                ];
                            @endphp
                            
                            @if (in_array(auth()->user()->role, $allowedRoles))
                                <td>
                                    <center>
                                    <div class="ok"style="width:220px;">
                                    <a href="/kelas/{{$kela->id}}/edit" class="btn btn-primary btn-sm my-1 mr-sm-1"><i class="nav-icon fas fa-pencil-alt"></i> Edit</a>
                                    @if (auth()->user()->role == 'admin')
                                   <a href="/kelas/{{$kela->id}}/delete" class="btn btn-danger btn-sm my-1 mr-sm-1" onclick="return confirm('Hapus Data ?')"><i class="nav-icon fas fa-trash"></i>
                                     Hapus</a>
                                    {{-- <a href="/kelas/{{$kelas->id}}/show" class="btn btn-success btn-sm my-1 mr-sm-1"><i class="nav-icon fas fa-child"></i> Detail</a> --}}
                                    @endif
                            
                                </div>
                            </center>
                                </td>
                                @endif
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