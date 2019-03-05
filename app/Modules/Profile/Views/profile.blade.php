@extends('layouts.app')

@php
use App\Models\Content;

  function timeElapsed($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
@endphp

@section('title')
  {{ $title }} | {{Content::content('site-name')}}
@endsection

@section('extra-css')
  	
@endsection

@section('content-header')
 	{{ $title }}
@endsection



@section('content')
	<div class="row">
	        <div class="col-xl-4 col-lg-5">

	          <!-- Profile Image -->
	          <div class="box">
	            <div class="box-body box-profile">
	              <img class="profile-user-img rounded-circle img-fluid mx-auto d-block" src="{{asset('assets/newassets/images/user-128.png')}}" alt="User profile picture">

	              <h3 class="profile-username text-center">{{ $user->name }}</h3>

	              <p class="text-muted text-center">Masuk sebagai <b>{{ $loginas->level }}</b></p>

	             

	              <div class="row">
	              	<div class="col-12">
	              		<div class="profile-user-info">
							<p>Username </p>
							<h6 class="margin-bottom"> {{ $user->username }}</h6>
							<p>No. HP</p>
							<h6 class="margin-bottom"> {{ $user->phone }} </h6>
							<p>Levels</p>
							<h6 class="margin-bottom">@foreach($levels as $level) <span class="label label-primary">{{ $level->level }} </span>@endforeach</h6>

						</div>
	             	</div>
	              </div>
	            </div>
	            <!-- /.box-body -->
	          </div>
	          <!-- /.box -->
	        </div>
	        <!-- /.col -->
	        <div class="col-xl-8 col-lg-7">
	          <div class="nav-tabs-custom">
	            <ul class="nav nav-tabs">

	              <li><a class="active" href="#timeline" data-toggle="tab">Aktivitas</a></li>
	              <li><a href="#settings" data-toggle="tab">Edit Profil</a></li>
	            </ul>

	            <div class="tab-content">

	             <div class="active tab-pane" id="timeline">
	                <!-- The timeline -->
	                <ul class="timeline">
						<!-- timeline time label -->
						<li class="time-label">
							  <span class="bg-info">
								Log Aktivitas Anda
							  </span>
						</li>
						<!-- /.timeline-label -->
						@foreach($logs as $log)
						<li>
						  <i class="fa fa-clock-o bg-green"></i>

						  <div class="timeline-item">
							<span class="time"><i class="fa fa-clock-o"></i> {{ timeElapsed($log->created_at) }}</span>

							<h3 class="timeline-header no-border"><a href="#">Anda</a> {{ $log->aktivitas }}</h3>
						  </div>
						</li>
					@endforeach
					  </ul>
	              </div>

	              <!-- /.tab-pane -->

	              <div class="tab-pane" id="settings">
	                <form class="form-horizontal form-element col-12" action="{{ route('users.update') }}" method="POST">
										{{ csrf_field() }}
										<input type="hidden" name="edit_id_user" id="edit_id_user" value="{{ $user->id }}">
						            <div class="row form-group {{ $errors->has('edit_name') ? ' has-error' : '' }}">
						                <label class="col-sm-3 control-label" for="edit_name">Name</label>
						                <div class="col-sm-9">
						                    <input type="text" required="" class="form-control" id="edit_name" name="edit_name" value="{{ old('edit_name', $user->name) }}" placeholder="Jackie Chan">
						                    @if ($errors->has('edit_name'))
						                        <span class="help-block">
						                            <strong>{{ $errors->first('edit_name') }}</strong>
						                        </span>
						                    @endif
						                </div>
						            </div>
						            <div class="row form-group {{ $errors->has('username') ? ' has-error' : '' }}">
						              <label class="col-sm-3 control-label" for="username">Username</label>
						              <div class="col-sm-9">
						                <input type="text" required="" class="form-control" value="{{ old('username', $user->username) }}" id="username" name="username">
						                @if ($errors->has('email'))
						                    <span class="help-block">
						                        <strong>{{ $errors->first('email') }}</strong>
						                    </span>
						                @endif
						              </div>
						            </div>

						            <div class="row form-group {{ $errors->has('password') ? ' has-error' : '' }}">
						              <label class="col-sm-3 control-label" for="password">Password</label>
						              <div class="col-sm-9">
						                <input type="password" class="form-control" id="password" name="password" placeholder="Your New Password or Empty">
						                @if ($errors->has('password'))
						                    <span class="help-block">
						                        <strong>{{ $errors->first('password') }}</strong>
						                    </span>
						                @endif
						              </div>
						            </div>

						            <div class="row form-group">
							            <label class="col-sm-3 control-label" for="password_confirmation">Confirm Password</label>
							            <div class="col-sm-9">
							            	<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Retype Password">
							            </div>
						            </div>

						        	<div class="row form-group {{ $errors->has('edit_phone') ? ' has-error' : '' }}">
						              <label class="col-sm-3 control-label" for="edit_phone">Phone</label>
						              <div class="col-sm-9">
						                <input type="number" required="" class="form-control" value="{{ old('edit_phone', $user->phone) }}" id="edit_phone" name="edit_phone" placeholder="081234567890">
						                @if ($errors->has('edit_phone'))
						                    <span class="help-block">
						                        <strong>{{ $errors->first('edit_phone') }}</strong>
						                    </span>
						                @endif
						              </div>
						            </div>

							        <div style="display:none" class="row form-group {{ $errors->has('edit_level') ? ' has-error' : '' }}">
							            <label class="col-sm-3 control-label">User Level(s)</label>
							            <div class="col-sm-9">
							              @foreach($levels as $level)
							                <div class="checkbox-custom checkbox-primary col-sm-12">
							                  <input type="checkbox" name="edit_level[]" id="edit_{{ $level->id }}" value="{{ $level->id }}" checked>
							                  <label for="edit_{{ $level->id }}">{{ $level->level }}</label>
							                </div>
							              @endforeach
							              @if ($errors->has('edit_level'))
							                  <span class="help-block">
							                      <strong>{{ $errors->first('edit_level') }}</strong>
							                  </span>
							              @endif
							            </div>
							        </div>
	                  <div class="form-group row">
	                    <div class="ml-auto col-sm-10">
	                      <button type="submit" class="btn btn-success">Submit</button>
	                    </div>
	                  </div>
	                </form>
	              </div>
	              <!-- /.tab-pane -->
	            </div>
	            <!-- /.tab-content -->
	          </div>
	          <!-- /.nav-tabs-custom -->
	        </div>
	        <!-- /.col -->
	      </div>
	      <!-- /.row -->

@endsection

@section('extra-js')


@endsection

@section('extra-js-inline')


@endsection
