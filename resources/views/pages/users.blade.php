@extends('layouts.app')

@section('title')
  Manajemen User | {{ App\Models\Content::content('site-name')}}
@endsection

@section('extra-css')

@endsection

@section('content-header')
  Manajemen User
@endsection

@section('content-header-right')
  <button class="btn btn-sm btn-default" data-target="#addUserModal" data-toggle="modal">
    <i class="icon wb-plus" aria-hidden="true"></i>
    <span class="hidden-xs">Tambah User</span>
  </button>
@endsection

@section('content')
  <div  class="row">
    <div class="col-12">
      <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar User</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>No HP</th>
                    <th>Level(s)</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>No HP</th>
                    <th>Level(s)</th>
                    <th>Aksi</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($users as $user)
                    <tr>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->username }}</td>
                      <td>{{ $user->phone }}</td>
                      <td >
                        @foreach($user->level as $level)
                          <span class="label label-primary d-inline-block text-center p-1 w-75"> {{$level->level}} </span><br>
                        @endforeach
                      </td>
                      <td>
                        <div class="btn-group" aria-label="User Action">
                          <button type="button" data-target="#formEditUserModal" value="{{ $user->id }}" data-toggle="modal" class="btn btn-sm btn-outline btn-primary">
                            <i class="fa fa-pencil" aria-hidden="true"></i>Edit
                          </button>
                          <button type="button" id="btnConfirmDelete" value="{{ $user->id }}" class="btn btn-outline  btn-sm btn-danger" data-target='#confirmDeleteModal' data-toggle='modal'>
                            <i class="fa fa-trash" aria-hidden="true"></i>Hapus
                          </button>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>

  </div>

  <!-- Add User Modals -->

  <div class="modal fade" id="addUserModal" aria-hidden="false" aria-labelledby="adduserModalLabel" role="dialog" tabindex="-1">
  	<div class="modal-dialog">
  		<div class="modal-content">
  			<div class="modal-header">
    			<h4 class="modal-title" id="myModalLabel">Add New User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		</div>
    		<div class="modal-body">
    			<form class="form-horizontal form-element" action="{{ route('users.create') }}" method="POST">
    				{{ csrf_field() }}
    				<div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
		                <label class="col-sm-3 control-label" for="name">Name</label>
		                <div class="col-sm-9">
		                    <input type="text" required="" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Jackie Chan">
		                    @if ($errors->has('name'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('name') }}</strong>
	                            </span>
	                        @endif
		                </div>
		            </div>
		            <div class="form-group row {{ $errors->has('username') ? ' has-error' : '' }}">
		                <label class="col-sm-3 control-label" for="username">Username</label>
		                <div class="col-sm-9">
		                    <input type="text" required="" class="form-control" value="{{ old('username') }}" id="username" name="username" placeholder="Username">
		                    @if ($errors->has('username'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('username') }}</strong>
	                            </span>
	                        @endif
		                </div>
		            </div>
		            <div class="row form-group {{ $errors->has('password') ? ' has-error' : '' }}">
		                <label class="col-sm-3 control-label" for="password">Password</label>
		                <div class="col-sm-9">
		                    <input type="password" class="form-control" required="" id="password" name="password" placeholder="Your Password">
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
		                    <input type="password" required="" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Retype Password">
		                </div>
		            </div>
		        	<div class="row form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
		                <label class="col-sm-3 control-label" for="phone">Phone</label>
		                <div class="col-sm-9">
		                    <input type="number" required="" class="form-control" value="{{ old('phone') }}" id="phone" name="phone" placeholder="081234567890">
		                    @if ($errors->has('phone'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('phone') }}</strong>
	                            </span>
	                        @endif
		                </div>
		            </div>

			        <div class="row form-group {{ $errors->has('level') ? ' has-error' : '' }}">
			            <label class="col-sm-3 control-label">User Level(s)</label>
			            <div class="col-md-6">
			              @foreach($level_form as $level)
			                <div class="checkbox-custom checkbox-primary col-sm-4">
			                  <input type="checkbox" name="level[]" id="{{ $level->id }}" value="{{ $level->id }}">
			                  <label for="{{ $level->id }}">{{ $level->level }}</label>
			                </div>
			              @endforeach
			              @if ($errors->has('level'))
                            <span class="help-block">
                                <strong>{{ $errors->first('level') }}</strong>
                            </span>
                          @endif
			            </div>
			        </div>
			        <div class="row col-md-3 pull-right">
		                <button class="btn btn-primary btn-outline" type="submit">Submit</button>
		            </div>
    			</form>
    		</div>
  		</div>
  	</div>
  </div>
  <!-- //Add User Modals -->

  <!-- Modal Delete Confirm -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-center" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <a id="deleteAnchor" href="" class='btn btn-danger'> Hapus</a>
        </div>
      </div>
    </div>
  </div>

  <!-- //end of Modal Delete Confirm -->

  <!-- Edit User Modals -->
  <div class="modal fade" id="formEditUserModal" aria-hidden="false" aria-labelledby="formEditUserModalLabel" role="dialog" tabindex="-1">
  	<div  class="modal-dialog">
  		<div class="modal-content">
  			<div class="modal-header">
  				<h4 class="modal-title" id="myModalLabel">Edit Data User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  			</div>
  			<div class="modal-body">
  				<form class="form-horizontal form-element" action="{{ route('users.update') }}" method="POST">
  					{{ csrf_field() }}
  					<input type="hidden" name="edit_id_user" id="edit_id_user" value="">
		            <div class="row form-group {{ $errors->has('edit_name') ? ' has-error' : '' }}">
		                <label class="col-sm-3 control-label" for="edit_name">Name</label>
		                <div class="col-sm-9">
		                    <input type="text" required="" class="form-control" id="edit_name" name="edit_name" value="{{ old('edit_name') }}" placeholder="Jackie Chan">
		                    @if ($errors->has('edit_name'))
		                        <span class="help-block">
		                            <strong>{{ $errors->first('edit_name') }}</strong>
		                        </span>
		                    @endif
		                </div>
		            </div>
		            <div class="row form-group {{ $errors->has('username') ? ' has-error' : '' }}">
		              <label class="col-sm-3 control-label" for="email">Username</label>
		              <div class="col-sm-9">
		                <input type="text" required="" class="form-control" value="{{ old('username') }}" id="username" name="username" placeholder="Username">
		                @if ($errors->has('username'))
		                    <span class="help-block">
		                        <strong>{{ $errors->first('username') }}</strong>
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
		                <input type="number" required="" class="form-control" value="{{ old('edit_phone') }}" id="edit_phone" name="edit_phone" placeholder="081234567890">
		                @if ($errors->has('edit_phone'))
		                    <span class="help-block">
		                        <strong>{{ $errors->first('edit_phone') }}</strong>
		                    </span>
		                @endif
		              </div>
		            </div>

			        <div class="row form-group {{ $errors->has('edit_level') ? ' has-error' : '' }}">
			            <label class="col-sm-3 control-label">User Level(s)</label>
			            <div class="col-sm-9">
			              @foreach($level_form as $level)
			                <div class="checkbox-custom checkbox-primary col-sm-12">
			                  <input type="checkbox" name="edit_level[]" id="edit_{{ $level->id }}" value="{{ $level->id }}">
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

			        <div class="row col-sm-5 pull-right">
		                <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
		                <button class="btn btn-default" data-dismiss="modal">Batal</button>
		            </div>
  				</form>
  			</div>
  		</div>
  	</div>
  </div>
  <!-- //Edit User Modals -->

@endsection

@section('extra-js')
  <!-- DataTables -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/newassets/assets/vendor_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
  <!-- This is data table -->
  <script src="{{ asset('assets/newassets/assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js') }}"></script>
  <!-- MinimalPro Admin for Data Table -->
  <script src="{{ asset('assets/newassets/js/pages/data-table.js') }}"></script>
@endsection
@section('extra-js-inline')
    <script>
      (function(document, window, $) {

        // Delete Modal
        // --
        $('#confirmDeleteModal').on('show.bs.modal', function(e) {
          var idUser = e.relatedTarget.value;
            document.getElementById("deleteAnchor").href = "";
          document.getElementById("deleteAnchor").href = '{{  $delete_route }}'+'/'+idUser;
        });

        // Edit Modal
        // --
        $('#formEditUserModal').on('show.bs.modal', function(e) {
          var id = e.relatedTarget.value;
            var urlDetail = '{{ $detail_route }}'+'/'+id;
            $.ajax({
                url: urlDetail,
                method: "get"
            }).done(function(data) {
                var response = $.parseJSON(data);
                console.log(urlDetail);
                console.log(response);
                document.getElementById('edit_id_user').value=response.id;
                document.getElementById('edit_name').value=response.name;
                document.getElementById('edit_phone').value=response.phone;
                $("input[name='username']").val(response.username);
                /*document.getElementById('edit_email').value=response.email;*/

                response.levels.forEach(function(k, v) {
            		$("input[name='edit_level[]'][value=" + k.id_level + "]").prop('checked', true);
        		});



            });
        });

        $('#formEditUserModal').on('hide.bs.modal', function(e) {
          document.getElementById('edit_id_user').value="";
            document.getElementById('edit_name').value="";
            $("input[name='username']").val('');

            /*document.getElementById('edit_email').value="";*/
            document.getElementById('edit_phone').value="";
            $("input[name='edit_level[]']").prop('checked', false);
        });

      })(document, window, jQuery);
    </script>

@endsection
