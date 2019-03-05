<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('assets/newassets/images/favicon.ico') }}">
  <title>Reset Password | ICMSE UNNES</title>
  <link rel="stylesheet" href="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/master_style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/skins/skin-green-light.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><b>ICMSE</b> UNNES</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body pb-20">
    <p class="login-box-msg text-uppercase">Recover password</p>
    @if (session('status'))
      <div class="alert alert-success" >
        {{ session('status') }}
      </div>
    @endif
    <form  method="POST" action="{{ route('password.email') }}" class="form-element">
      {{ csrf_field() }}
      <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Your Email" value="{{ old('email') }}" required>
        <span class="ion ion-email form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-info btn-block text-uppercase">Reset</button>
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
