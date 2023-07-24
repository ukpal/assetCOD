<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <title>AssetCOD | Dashboard</title> -->
  <title>@yield('title')</title>

  @include('Administrator.Layout.cssLink')
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  @include('Administrator.Layout.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

  @include('Administrator.Layout.sidebar')

  <!-- Content Wrapper. Contains page content -->


    <!-- Main content -->
    @yield('content')
    <!-- /.content -->
  <!-- </div> -->
  <!-- /.content-wrapper -->
  @include('Administrator.Layout.footer')
  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('Administrator.Layout.jsLink')

@yield('module_script')

@yield('ajaxStatus')
@yield('ajaxStatusCompany')

@yield('add_js')
@yield('new_com_scripts')

<script>
  setTimeout(function(){
    $('.toast').fadeOut();
  },4000);
</script>


</body>
</html>
