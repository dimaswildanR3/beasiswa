<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Program Beasiswa</title>
    <style type="text/css">
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999;
        }

        .loading {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font: 14px arial;
        }
    </style>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/adminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/adminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminLTE/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminLTE/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/adminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/adminLTE/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminLTE/css/adminlte.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/adminLTE/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/adminLTE/plugins/summernote/summernote-bs4.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/adminLTE/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/adminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- responsive image  -->
    <style>
        .img-responsive {
            width: 100%;
            min-height: 200px;
        }
    </style>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="preloader">
        <div class="loading">
            <div class="row">
                <div class="col d-flex align-items-center">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem;height: 3rem">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="col text-primary d-flex align-items-center">
                    <h6>Loading......</h6>
                </div>
                <div class="col d-flex align-items-center">
                    <div class="spinner-grow text-primary" role="status" style="width: 1rem;height: 1rem">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                <a class="nav-link font-weight-bold">PROGRAM BEASISWA</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle " href="javascript:void(0)" data-toggle="dropdown">
                        <i class="fas fa-user mr-2"></i> &nbsp;<span>{{auth()->user()->name}}</span> &nbsp;<i class="icon-submenu lnr lnr-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">Profil</span>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" data-toggle="modal" href="javascript:void(0)" data-target="#lihatprofile">
                            <i class="fas fa-user mr-2"></i> Lihat Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="/auths/{{auth()->user()->id}}/gantipassword" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2"></i> Ganti Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="/logout" class="dropdown-item" onclick="return confirm('Apakah anda yakin ingin keluar dari sistem ?')">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Brand Logo -->
            @if (auth()->user()->role == 'admin' )
            <a href="#" class="brand-link bg-info">
                <center>
                {{-- "<img src="/logo.png" alt="Logo" class="brand-image" style="opacity: .;"> --}}
            </center>
                <span class="brand-text font-weight-white">Beranda</span>
            </a>
            @endif

            @if (auth()->user()->role == 'Siswa')
            <a href="/{{$id_pesdik_login->id}}/siswadashboard" class="brand-link bg-primary">
                <img src="/logo.png" alt="Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-white">Beranda</span>
            </a>
            @endif
            <!-- Sidebar -->
            <div class="sidebar">
                @if (auth()->user()->role == 'admin')
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Sidebar Menu -->
                    <a>
                        <span class="text-black">Menu</span>
                    </a>
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->                
                    <li class="nav-item">
                        <a href="/dashboardd" class="nav-link">
                            <i class="nav-icon fas fa-bars"></i>
                            
                            <p>
                                Dashborad
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/perhitunganbeasiswa/index" class="nav-link">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>
                                Penghitungan Beasiswa
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sharp fa-light fa-pen"></i>
                            <p>
                                Input
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview bg-light">
                            <li class="nav-item">
                                <a href="/siswa/index" class="nav-link text-black">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>Siswa</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/nilaipelajaran/index" class="nav-link text-black">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>Nilai Ajaran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/beasiswa/index" class="nav-link text-black">
                                    <i class="fas fa-solid fa-wallet nav-icon"></i>
                                    <p>Beasiswa</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/kriteria/index" class="nav-link text-black">
                                    <i class="fas fa-solid fa-wallet nav-icon"></i>
                                    <p>Kriteria</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/models/index" class="nav-link text-black">
                                    <i class="fas fa-solid fa-wallet nav-icon"></i>
                                    <p>Model</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/penilaian/index" class="nav-link text-black">
                                    <i class="fas fa-solid fa-marker nav-icon"></i>
                                    <p>Penilaian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/pesyaratan/index" class="nav-link text-black">
                                    <i class="fas fa-check nav-icon"></i>
                                    <p>Pesyaratan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sharp fa-light fa fa-file"></i>
                            <p>
                                Laporan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview bg-light">
                            <li class="nav-item">
                                <a href="/laporansiswa/index" class="nav-link text-black">
                                    <i class="far fas fa-user nav-icon"></i>
                                    <p>Laporam BP</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/laporasseluruh/index" class="nav-link text-black">
                                    <i class="far fas fa fa-file nav-icon"></i>
                                    <p>Laporam BKM</p>
                                </a>
                            </li>
                            
                            {{-- <li class="nav-item">
                                <a href="/laporanpendaftaran/index" class="nav-link text-black">
                                    <i class="far fas fa fa-file nav-icon"></i>
                                    <p>Laporan Pendaftaran</p>
                                </a>
                            </li>                         --}}
                        </ul>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="/klasifikasi/index" class="nav-link">
                            <i class="nav-icon fas 	fa fa-file"></i>
                            <p>
                                Laporan
                            </p>
                        </a>
                    </li> --}}
                   
                </ul>
                @endif            
                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'PetugasAdministrasiSurat' || auth()->user()->role == 'PetugasAdministrasiKeuangan')
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Sidebar Menu -->
                    <a class="text-black">
                        <p>
                            Profil
                        </p>
                    </a>
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    
                    @if (auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('pengguna.index') }}" class="nav-link">
                            <i class="fas fa-user-cog nav-icon"></i>
                            <p>
                                Pengguna
                            </p>
                        </a>
                    </li>
                    @endif
                </ul>
                @endif
                @if (auth()->user()->role == 'Siswa')
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">

                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>
                                Rekap Tabungan
                                <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview bg-secondary">
                            <li class="nav-item">
                                <a href="/tabungan/setor/{{$id_pesdik_login->id}}/siswaindex" class="nav-link text-white">
                                    <i class="fas fa-credit-card nav-icon"></i>
                                    <p>Setor Tunai</p>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/tabungan/tarik/{{$id_pesdik_login->id}}/siswaindex" class="nav-link text-white">
                                    <i class="fas fa-credit-card nav-icon"></i>
                                    <p>Tarik Tunai</p>

                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="/pembayaran/transaksipembayaran/{{$id_pesdik_login->id}}/siswaindex" class="nav-link">
                            <i class="far fa-handshake nav-icon"></i>
                            <p>
                                Rekap Pembayaran
                            </p>
                        </a>
                    </li>
                </ul>
                @endif
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper bg-light" style="padding: 15px 15px 15px 15px ">
            @yield('content')

        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer bg-info">
            {{-- <div class="float-right d-none d-sm-block">
                <b>Smpn 1 sron banyuwangi | </b>
                Versi 1.0.0
            </div> --}}
            Copyright &copy; 2025 | by : adywisma
        </footer>


        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- Ck editor -->
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <!-- jQuery -->
    <script src="/adminLTE/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/adminLTE/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="/adminLTE/plugins/select2/js/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/adminLTE/js/adminlte.min.js"></script>
    <!-- Ekko Lightbox -->
    <script src="/adminLTE/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <!-- Filterizr-->
    <script src="/adminLTE/plugins/filterizr/jquery.filterizr.min.js"></script>
    <!-- Data Table -->
    <script src="/adminLTE/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- overlayScrollbars -->
    <script src="/adminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/adminLTE/js/demo.js"></script>


    <script>
        CKEDITOR.replace('isi_pengumuman');
    </script>

    <script>
        $(document).ready(function() {
            $(".preloader").fadeOut("1000");
        });
    </script>
    <!-- page script -->
    <script>
        // Untuk Menampilkan Button kembali
        function viewKembali() {
            var button = document.getElementById("kembali");

            if (button.style.display === "none") {
                button.style.display = "block";
            } else {
                button.style.display = "none";
            }
        }
        // end Untuk Menampilkan Button kembali

        // Untuk Menampilkan Button Bayar
        function myFunction() {
            // Get the checkbox
            var checkBox = document.getElementById("pilih[]");
            // Get the output text
            var text = document.getElementById("bayar");

            // If the checkbox is checked, display the output text
            if (checkBox.checked == true) {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
        // end Untuk Menampilkan Button Bayar

        $(function() {
            $("#tabelSuratmasuk").DataTable();
            $("#tabelSuratkeluar").DataTable();
            $("#tabelAgendaMasuk").DataTable();
            $("#tabelAgendaKeluar").DataTable();
            $("#tabelTagihan").DataTable();
            $("#tabelKlasifikasi").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
            });
            $("#tabelTagihanInvoice1").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": true,
            });
            $("#tabelTagihanInvoice2").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": true,
            });

            $("#agenda").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": true,
            });
            $("#agenda2").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": true,
            });
            $("#notOrdering").DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": true,
            });
        });

        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('.filter-container').filterizr({
                gutterPixels: 3
            });
            $('.btn[data-filter]').on('click', function() {
                $('.btn[data-filter]').removeClass('active');
                $(this).addClass('active');
            });
        });

        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
 <script>
    // Fungsi untuk mengatur paginasi default menjadi 100 pada semua tabel dengan class "dataTable"
    function setDefaultPagination() {
        $(".dataTable").DataTable().page.len(100).draw();
    }

    // Panggil fungsi setDefaultPagination() saat halaman selesai diload
    $(document).ready(function() {
        setDefaultPagination();
    });
</script>
    <!-- Modal Profile -->
    <div class="modal fade" id="lihatprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"><i class="nav-icon fas fa-user my-1 btn-sm-1"></i>
                        &nbsp;Profil Pengguna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6><label for="nama">Nama </label></h6>
                        </div>
                        <div class="col-md-9">
                            <h6><label for="nama"> : {{auth()->user()->name}}</label></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h6><label for="nama">Email </label></h6>
                        </div>
                        <div class="col-md-9">
                            <h6><label for="nama"> : {{auth()->user()->email}}</label></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <h6><label for="nama">Level User </label></h6>
                        </div>
                        <div class="col-md-9">
                            <h6><label for="nama"> : {{auth()->user()->role}}</label></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

</body>

</html>