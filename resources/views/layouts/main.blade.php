<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">

</head>

<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed ">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/dist/img/bookioDark.png" alt="AdminLTELogo" height="40">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link " data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/home" class="nav-link">Home</a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">


                <!-- Notifications Dropdown Menu -->
                {{-- <li class="nav-item dropdown mr-5">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span
                            class="badge badge-warning navbar-badge">{{ count(DB::table('notifications')->get()->where('user_id',DB::table('users')->get()->firstWhere('level', 'admin')->id)) }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item f dropdown-footer">See All Notifications</a>
                    </div>
                </li> --}}
                <form action="/logout" method="post">
                    @csrf
                    <button class="btn btn-success"><i class="fa-solid fa-right-from-bracket"></i> Logout
                        dashboard</button>
                </form>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-orange elevation-4">
            <!-- Brand Logo -->
            <a href="/home" class="brand-link">
                <img src="/dist/img/bookioAdmin.png" alt="AdminLTE Logo" class="brand-image " style="margin-left: 65px"
                    height="30">
                <span class="brand-text font-weight-light">
                    <p></p>
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-flat nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="/home" class="nav-link {{ $title == 'Home' ? 'active' : '' }}">
                                <i class="nav-icon far fa-solid fa-house"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item {{ $title == 'Data User Penyewa' || $title == 'Data User Penyedia' || $title == 'Data User Member' ? 'menu-open' : '' }} ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-users"></i>
                                <p>
                                    Data Users
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- <li class="nav-item" @if (auth()->user()->level != 'admin') hidden @endif>
                                    <a href="/userMember"
                                        class="nav-link {{ $title == 'Data User Member' ? 'active' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User Member</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="/userPenyewa"
                                        class="nav-link {{ $title == 'Data User Penyewa' ? 'active' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User Penyewa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/userPenyedia"
                                        class="nav-link {{ $title == 'Data User Penyedia' ? 'active' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User Penyedia</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/dataStudio" class="nav-link {{ $title == 'Data Studio' || $title == 'Detail Studio'? 'active' : '' }} ">
                                <i class="nav-icon far fa-solid fa-microphone-lines"></i>
                                <p>
                                    Data Studio
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/dataPemesanan"
                                class="nav-link  {{ $title == 'Data Pemesanan' ? 'active' : '' }} ">
                                <i class="nav-icon far fa-solid fa-cart-shopping"></i>
                                <p>
                                    Data Pemesanan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/dataTransaksi"
                                class="nav-link {{ $title == 'Data Transaksi & Keuangan' ? 'active' : '' }} ">
                                <i class="nav-icon far fa-solid fa-clipboard"></i>
                                <p>
                                    Transaksi & Keuangan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/dataWithdraw" class="nav-link {{ $title == 'Data Withdraw' ? 'active' : '' }} ">
                                <i class="nav-icon far fa-solid fa-money-bill-transfer"></i>
                                <p>
                                    Data Withdraw
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item 
                                @if (count(DB::table('kategoris')->get()) != null) @foreach (DB::table('kategoris')->get() as $kategori)
                                        @if ($title == 'Akun Admin' || $title == 'Akun Pembayaran' || $title == $kategori->name)
                                            {{ 'menu-open' }}
                                            @break @endif
                                    @endforeach
@else
{{ $title == 'Akun Admin' || $title == 'Akun Pembayaran' || $title == 'Ubah Password' ? 'menu-open' : ' ' }} 
                                    @endif
                            ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-solid fa-gear"></i>
                                <p>
                                    Pengaturan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/akunAdmin"
                                        class="nav-link {{ $title == 'Akun Admin' ? 'active' : '' }} ">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Akun</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/pembayaran"
                                        class="nav-link {{ $title == 'Akun Pembayaran' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pembayaran</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/ubahPassword"
                                        class="nav-link {{ $title == 'Ubah Password' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ubah Password</p>
                                    </a>
                                </li>
                                @foreach (DB::table('kategoris')->get() as $kategori)
                                    <li class="nav-item ">
                                        <a href="/detailKategori/{{ $kategori->id }}"
                                            class="nav-link {{ $title == $kategori->name ? 'active' : '' }}  ">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ $kategori->name }}</p>
                                        </a>
                                    </li>
                                @endforeach
                                {{-- looping --}}
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ $title }}</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">{{ $title }}</a></li>

                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="container-fluid">
                    @yield('container')
                </div>

                <!-- modal konfirmasi pembayaran -->
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="konfirmasi" class="modal-title">Konfirmasi Pembayaran...?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" data-dismiss="modal"
                                    class="btn btn-success">Konfirmasi</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <!-- modal batalkan pemesanan -->
                <div class="modal fade" id="modal-batal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Batalkan Pemesanan...?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" data-dismiss="modal" class="btn btn-danger">Batalkan
                                    Pemesanan</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <!-- modal export withdraw -->
                <div class="modal fade" id="modal-export-withdraw">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Export Laporan Withdraw ke PDF</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <p>Tanggal Awal</p>
                                            <input id="tglawal" type="date">
                                        </div>
                                        <div class="col">
                                            <p>Tanggal Awal</p>
                                            <input id="tglakhir" type="date">
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <a onclick="this.href='/cetak/withdraw/'+document.getElementById('tglawal').value + '/'+document.getElementById('tglakhir').value" type="button" target="_blank" class="btn btn-success"><i
                                        class="fa-solid fa-file-export mr-2"></i>Export PDF</a>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                 <!-- modal export PDF -->
                 <div class="modal fade" id="modal-export">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Export file ke PDF</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <p>Tanggal Awal</p>
                                            <input id="tglawal1" type="date">
                                        </div>
                                        <div class="col">
                                            <p>Tanggal Awal</p>
                                            <input id="tglakhir1" type="date">
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <a onclick="this.href='/cetak/transaksi/'+document.getElementById('tglawal1').value + '/'+document.getElementById('tglakhir1').value" type="button" target="_blank" class="btn btn-success"><i
                                        class="fa-solid fa-file-export mr-2"></i>Export PDF</a>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <!-- modal tambah member -->

                <div class="modal fade" id="modal-add-member">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Tambah Data Member</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">

                                    <form action="/userMember/add" method="post">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Full name" required value="{{ old('name') }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input name="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Email" required value="{{ old('email') }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-3">
                                            <input name="nomor_hp" type="number"
                                                class="form-control @error('nomor_hp') is-invalid @enderror"
                                                placeholder="Nomor Hp" required value="{{ old('nomor_hp') }}">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                            @error('nomor_hp')
                                                <div class="invalid-feedback">
                                                    The number is invalid, example "6283115671593"
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="input-group mb-3">
                                            <input name="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Password" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="input-group mb-3">
                                            <input name="retype_password" type="password"
                                                class="form-control @error('retype_password') is-invalid @enderror"
                                                placeholder="Retype password" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                            @error('retype_password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary  btn-block"> <i
                                                        class="fa fa-add"></i> Tambah Member</button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <!-- modal konfirmasi withdraw -->
                <div class="modal fade" id="modal-konfirmasi-withdraw">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="konfirmasi" class="modal-title">Konfirmasi withdraw..?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" data-dismiss="modal"
                                    class="btn btn-success">Konfirmasi</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>




            </section>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>




        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->



    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/plugins/jszip/jszip.min.js"></script>
    <script src="/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script src="https://kit.fontawesome.com/eda8884b8f.js" crossorigin="anonymous"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    {{-- <!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script> --}}

</body>

</html>
