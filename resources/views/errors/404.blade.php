<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('assets/newassets/images/favicon.ico') }}">
  <title>404 - Not Found | {{App\Content::content('site-name')}}</title>
  <link rel="stylesheet" href="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/master_style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/skins/skin-green-light.css') }}">

</head>
<body class="hold-transition">
  <div class="error-body">
      <div class="error-page">

        <div class="error-content">
          <div class="container">
          
            <h2 class="headline text-yellow"> 404</h2>
            
        <h3 class="margin-top-0"><i class="fa fa-warning text-yellow"></i> PAGE NOT FOUND !</h3>

        <p>
        {{ $exception->getMessage() }}
        </p>
        <div class="text-center">
          <a href="{{ url('/dashboard') }}" class="btn btn-info btn-block margin-top-10">Back to dashboard</a>
        </div>
          </div>
        </div>
        <!-- /.error-content -->
        <footer class="main-footer">
          Copyright &copy; 2017 <a href="#">Midnight-dev.com</a>. All Rights Reserved.
    </footer>
 
      </div>
      <!-- /.error-page -->
     </div> 
  
  <!-- jQuery 3 -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- popper -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/popper/dist/popper.min.js') }}"></script>
  <!-- Bootstrap 4.0-->
  <script src="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>