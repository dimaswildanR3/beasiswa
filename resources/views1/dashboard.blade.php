@extends('layouts.master')
@section('content')
@if(session('warning'))
<div class="callout callout-warning alert alert-warning alert-dismissible fade show" role="alert">
  <h5><i class="fas fa-info"></i> Peringatan :</h5>
  {{session('warning')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<div class="row">
  <div class="container-fluid">
    <!-- Info boxes -->
    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'PetugasAdministrasiSurat')
    <div class="row">
      <div class="flex-fill col-md-3" style="padding: 4px 4px 4px 4px">
        <div class="info-box md-3">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Beasiswa</span>
            <span class="info-box-number">
              {{DB::table('beasiswa')->count() ?:0}}
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class=" flex-fill col-md-3" style="padding: 4px 4px 4px 4px">
        <div class="info-box md-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-envelope-open"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Kriteria</span>
             <span class="info-box-number">{{DB::table('kriteria')->count()?:0}}</span> 
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <!-- fix for small devices only -->
      <div class="flex-fill col-md-3" style="padding: 4px 4px 4px 4px">
        <div class="info-box md-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">siswa</span>
            <span class="info-box-number">{{DB::table('siswa')->count()?:0}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class=" flex-fill" style="padding: 4px 4px 4px 4px">
        <div class="info-box md-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Pengguna</span>
            <span class="info-box-number">{{DB::table('users')->count()?:0}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    @endif
    <!-- /.row -->
  </div>
  @if (auth()->user()->role == 'admin' || auth()->user()->role == 'PetugasAdministrasiKeuangan')
  <!--<div class="col-md-9">-->
  <!--  <section class="content card" style="padding: 15px 15px 40px 15px ">-->
  <!--    <div class="box">-->
  <!--      <div class="row">-->
  <!--        <div class="col">-->
  <!--          <h4><i class="nav-icon fas fa-warehouse my-0 btn-sm-1"></i> Rekap Data Sekolah</h4>-->
  <!--          <hr>-->
  <!--        </div>-->
  <!--      </div>-->
  <!--      <div class="card-body">-->
          <!-- Small boxes (Stat box) -->
  <!--        <div class="filter-container p-0 row d-flex justify-content-center">-->
  <!--          <div class="col-lg-4 col-md-6">-->
              <!-- small box -->
  <!--            <div class="small-box bg-info">-->
  <!--              <div class="inner">-->
  <!--                <h3>{{DB::table('nilai')->where('id_beasiswa',1)->count()?:0}}</h3>-->
  <!--                <p>Laporan Beasiswa Prestasi</p>-->
  <!--              </div>-->
  <!--              <div class="icon">-->
  <!--                <i class="nav-icon fas fa-graduation-cap"></i>-->
  <!--              </div>-->
  <!--              <p class="small-box-footer">Laporan Beasiswa Prestasi</p>-->
  <!--            </div>-->
  <!--          </div>-->
  <!--          <div class="col-lg-5 col-md-6">-->
              <!-- small box -->
  <!--            <div class="small-box bg-success">-->
  <!--              <div class="inner">-->
  <!--                <h3>{{DB::table('nilai')->where('id_beasiswa',2)->count()?:0}}</h3>-->
  <!--                <p>Laporan Beasiswa Kurang Mampu</p>-->
  <!--              </div>-->
  <!--              <div class="icon">-->
  <!--                <i class="nav-icon fas fa-graduation-cap"></i>-->
  <!--              </div>-->
  <!--              <p class="small-box-footer">Laporan Beasiswa Kurang Mampu</p>-->
  <!--            </div>-->
  <!--          </div>-->
            <!-- ./col -->
  <!--          <div class="col-lg-3 col-md-6">-->
              <!-- small box -->
  <!--            <div class="small-box bg-warning">-->
  <!--              <div class="inner">-->
  <!--                {{-- <h3>{{DB::table('pesdik')->where('status',"Aktif")->count()}}</h3> --}}-->
  <!--                <h3>{{DB::table('nilai')->count()?:0}}</h3>-->
  <!--                <p>Perhitungan Beasiswa</p>-->
  <!--              </div>-->
  <!--              <div class="icon">-->
  <!--                <i class="nav-icon fas fa-child nav-icon"></i>-->
  <!--              </div>-->
  <!--              <p class="small-box-footer">Perhitungan Beasiswa</p>-->
  <!--            </div>-->
  <!--          </div>-->
  <!--          <div class="col-lg-3 col-md-6">-->
              <!-- small box -->
             
  <!--        </div>-->
  <!--      </div>-->
  <!--    </div>-->
  <!--  </section>-->
  <!--</div>-->
  @endif
 


  @endsection