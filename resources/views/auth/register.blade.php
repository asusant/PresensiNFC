<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="{{ asset('assets/newassets/images/favicon.ico') }}">
  <title>Register | Dekopinda</title>
  <link rel="stylesheet" href="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/master_style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/newassets/css/skins/skin-green-light.css') }}">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="{{ url('/') }}">DEKOPINDA</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form method="POST" action="{{ route('register') }}" class="form-element">
      {{ csrf_field() }}
      <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
        <input type="text" class="form-control" id="inputName" placeholder="Full Name" name="name" value="{{ old('name') }}" required autofocus>
        <span class="ion ion-person form-control-feedback"></span>
        @if ($errors->has('name'))
            <span class="help-block">
                {{ $errors->first('name') }}
            </span>
        @endif
      </div>

      <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <span class="ion ion-email form-control-feedback "></span>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" id="inputPassword" name="password"
        placeholder="Password" required>
        <span class="ion ion-locked form-control-feedback "></span>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control"id="password-confirm" name="password_confirmation" required
        placeholder="Confirm Password">
        <span class="ion ion-log-in form-control-feedback "></span>
      </div>

      <div class="form-group">
        <select class="form-control select2-hidden-accessible" data-plugin="select2" name="level" data-placeholder="Select the Country" data-allow-clear="true">
          <optgroup label="--- User Level ---">
              <option value="4">Direktur</option>
              <option value="5">Keuangan</option>
              <option value="6">Staff Distribusi</option>
              <option value="7">Supervisor Distribusi</option>
          </optgroup>
        </select>
        @if ($errors->has('level'))
          <span class="help-block">
              <strong>{{ $errors->first('level') }}</strong>
          </span>
        @endif
      </div>

      <div class="row">
        <!-- /.col -->
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-info btn-block margin-top-10">SIGN UP</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

     <div class="margin-top-20 text-center">
      <p>Already have an account?<a href="{{ route('login') }}" class="text-info m-l-5"> Sign In</a></p>
     </div>

  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
  <!-- jQuery 3 -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- popper -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/popper/dist/popper.min.js') }}"></script>
  <!-- Bootstrap 4.0-->
  <script src="{{ asset('assets/newassets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>
