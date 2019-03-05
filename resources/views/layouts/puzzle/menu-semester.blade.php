<li class="dropdown notifications-menu">
  <a href="#" class="dropdown-toggle font-weight-normal" data-toggle="dropdown">
    <small> <strong> {{ $semesterAktif->semester }} </strong> </small> &nbsp; <i class="fa fa-calendar"></i>
  </a>
  <ul class="dropdown-menu scale-up">
    <li class="header">Semester Aktif</li>
    <li>
      <!-- inner menu: contains the actual data -->
      <ul class="menu inner-content-div">
      	@foreach ($semester as $row)
  			<li>
  				<a href="{{ route('change-semester', $row->id)}}">
  					@if($row->id == session('id_semester'))
  						<i class="glyphicon glyphicon-ok text-aqua"></i> 
  					@endif {{$row->semester}}
  				</a>
  			</li>
		    @endforeach
      </ul>
    </li>
  </ul>
</li>