<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
      	<li class="user-profile" style="background-image: url({{ asset('assets/newassets/images/user-info.jpg') }})">
          <a href="{{ route('profile.read') }}">
			<img src="{{ asset('assets/newassets/images/user.png') }}" alt="user">
            <span>{{ Auth::user()->name }}</span>
          </a>
        </li>
        <li class="header nav-small-cap">MENU</li>
        
        @foreach ($menus as $menu)
        	@php 
        		$submenus = App\Http\Controllers\BaseController::getSubmenu($menu['id_menu']); 
        		$route = Request::route()->getName();
        		$elm = explode('.', $route);
				$first = reset($elm);
        	@endphp
         	
         	@if(count($submenus) > 0)
				<li class="treeview @if($menu['route'] == $first) active @endif">
		          <a href="#">
		            <i class="fa {{ $menu['icon'] }}"></i>
		            <span>{{ $menu['menu'] }}</span>
		            <span class="pull-right-container">
		              <i class="fa fa-angle-right pull-right"></i>
		            </span>
		          </a>
		          <ul class="treeview-menu">
		          	@foreach ($submenus as $submenu)
		            	<li @if($submenu['routing'] == Request::route()->getName()) class="active" @endif>
		            		<a href="{{ route($submenu['routing'])}}"><i class="fa fa-circle-thin"></i>{{ $submenu['submenu']}}</a>
		            	</li>
					@endforeach
		          </ul>
		        </li>
         	@else
				<li @if($menu['route'] == $first) class="active" @endif>
			        <a href="{{ route($menu['routing']) }}">
			          <i class="fa {{ $menu['icon'] }}"></i> <span>{{ $menu['menu'] }}</span>
			        </a>
			    </li>
         	@endif
        
        @endforeach
      </ul>
    </section>
</aside>