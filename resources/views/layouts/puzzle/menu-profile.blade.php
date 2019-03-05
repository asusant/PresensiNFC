<li class="dropdown user user-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="mdi mdi-account-circle"></i>
  </a>
  <ul class="dropdown-menu scale-up">
    <!-- User image -->
    <li class="user-header">
      <img src="{{ asset('assets/newassets/images/user-128.png') }}" class="float-left rounded-circle" alt="User Image">
      <p>
        {{ Auth::user()->name }}
        <small class="mb-5">{{ Auth::user()->email }}</small>
      </p>
    </li>
    <!-- Menu Body -->
    <li class="user-body">
      <div class="row no-gutters">
        <div class="col-12 text-left">
          <a href="{{url('profile')}}"><i class="ion ion-person"></i>Profil</a>
        </div>
        <div role="separator" class="divider col-12"></div>
        <div class="col-12 text-left">
          <form id="logot" action="{{ route('logout')}}" method="post">{{ csrf_field() }}</form>
           <a role="menuitem" href="javascript:{}"onclick="document.getElementById('logot').submit();"><i class="fa fa-power-off"></i> Logout </a>
        </div>        
      </div>
      <!-- /.row -->
    </li>
  </ul>
</li>