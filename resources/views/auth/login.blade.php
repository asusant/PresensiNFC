<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('assets/newassets/images/favicon.ico') }}">
  <title>Login | {{App\Content::content('site-name')}}</title>
  <link rel="stylesheet" href="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/master_style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/skins/skin-green-light.css') }}">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}">{{App\Content::content('site-name')}}</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Silahkan Login untuk masuk sistem</p>
      @if(session()->has('gagal'))
    <div class="alert alert-danger">
          {{ session()->get('gagal') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      @endif
    <form method="POST" action="{{ route('login') }}" class="form-element">
      {{ csrf_field() }}
      <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
        <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Username" required autofocus>
          @if ($errors->has('username'))
              <span class="help-block">
                  <strong>{{ $errors->first('username') }}</strong>
              </span>
          @endif
        <span class="ion ion-email form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <span class="ion ion-locked form-control-feedback"></span>
      </div>
      <div class="row">
      
        <!-- /.col -->
        
        <!-- /.col -->
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-info btn-block margin-top-10">SIGN IN</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
  <!-- jQuery 3 -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- popper -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/popper/dist/popper.min.js') }}"></script>
  <!-- Bootstrap 4.0-->
  <script src="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>
