<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('assets/newassets/images/favicon.ico') }}">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/css/bootstrap-extend.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/master_style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/skins/_all-skins.css') }}">
  @yield('extra-css')
  @yield('extra-css-inline')
</head>
<body class="hold-transition skin-yellow sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
    <b class="logo-mini">

    </b>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
      {{ App\Models\Content::content('site-name') }}
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Puzzle Semester -->
          @include('layouts.puzzle.menu-semester')
          <!-- Puzzle Levels -->
          @include('layouts.puzzle.menu-levels')
          <!-- Puzzle Profile -->
          @include('layouts.puzzle.menu-profile')
        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the sidebar -->
  @include('layouts.puzzle.sidebar')

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('content-header')
      </h1>
      <ol class="breadcrumb">
        @yield('content-header-right')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts.puzzle.flash-message')
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <footer class="main-footer">

    &copy; 2018 by {{App\Models\Content::content('site-name')}}. All Rights Reserved.

  </footer>
</div>
  <!-- jQuery 3 -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- popper -->
	<script src="{{ asset('assets/newassets/assets/vendor_components/popper/dist/umd/popper.min.js') }}"></script>
	<!-- Bootstrap 4.0-->
	<script src="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <!-- SlimScroll -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/fastclick/lib/fastclick.js') }}"></script>
  <!-- MinimalPro Admin App -->
  <script src="{{ asset('assets/newassets/js/template.js') }}"></script>
  <!-- MinimalPro Admin for demo purposes -->
  <script src="{{ asset('assets/newassets/js/demo.js') }}"></script>

  <!-- DataTables -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/newassets/assets/vendor_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
  <!-- This is data table -->
  <script src="{{ asset('assets/newassets/assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js') }}"></script>
  <!-- MinimalPro Admin for Data Table -->
  <script src="{{ asset('assets/newassets/js/pages/data-table.js') }}"></script>
  @yield('extra-js')
  @yield('extra-js-inline')

</body>
</html>
