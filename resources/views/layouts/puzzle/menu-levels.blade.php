<li class="dropdown notifications-menu">
  <a href="#" class="dropdown-toggle font-weight-normal" data-toggle="dropdown">
    @php
      $lvl_now = "";
      foreach ($levels as $level) {
        if ($level->id == session('id_level')) {
          $lvl_now = $level->level;
          break;
        }
      }
    @endphp
    <small> <strong> {{ Auth::user()->name }} </strong> as <strong> {{ $lvl_now }} </strong> </small> &nbsp; <i class="mdi mdi-account-settings"></i>
  </a>
  <ul class="dropdown-menu scale-up">
    <li class="header">Choose Level</li>
    <li>
      <!-- inner menu: contains the actual data -->
      <ul class="menu inner-content-div">
      	@foreach ($levels as $level)
			<li>
				<a href="{{ route('change-level', $level->id)}}">
					@if($level->id == session('id_level'))
						<i class="glyphicon glyphicon-ok text-aqua"></i> 
					@endif {{$level->level}}
				</a>
			</li>
		@endforeach
      </ul>
    </li>
  </ul>
</li>