@extends('layouts.app')

@section('title')
  {{ $title }} | {{ App\Models\Content::content('site-name') }}
@endsection

@section('extra-css')
  	
@endsection

@section('content-header')
 	{{ $title }}
@endsection

@section('content-header-right')
  {!! $create_button !!}
@endsection

@section('content')
  <div  class="row">
    <div class="col-12">
      <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	<div class="table-responsive">
          <table id="table" class="table table-bordered table-striped">
           <thead>
             <tr class="primary">
               <th width="7%">No</th>
               <th >Menu</th>
               <th >routing</th>
               <th >Icon Code</th>
               <th >Urutan</th>
               <th >Dibuat oleh</th>
               <th width="20%">Aksi</th>
             </tr>

           </thead>
         </table>
          </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>

  </div>

  <!-- Add User Modals -->
  <div class="modal fade" id="add" aria-hidden="false" aria-labelledby="adduserModalLabel" role="dialog" tabindex="-1">
  	<div class="modal-dialog">
  		<div class="modal-content">
  			<div class="modal-header">
    			<h4 class="modal-title" id="myModalLabel">Tambah {{ $title }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    		</div>
    		<div class="modal-body">
    			<form class="form-horizontal form-element" action="{{ $create_route }}" method="POST">
    				{{ csrf_field() }}
						<div class="row form-group {{ $errors->has('menu') ? ' has-error' : '' }}">
								<label class="col-sm-3 control-label" for="menu">Menu</label>
								<div class="col-sm-9">
										<input type="text" required="" class="form-control" id="menu" name="menu" value="{{ old('menu') }}" placeholder="Application Configs">
										@if ($errors->has('menu'))
												<span class="help-block">
														<strong>{{ $errors->first('menu') }}</strong>
												</span>
										@endif
								</div>
						</div>
            <div class="row form-group {{ $errors->has('route') ? ' has-error' : '' }}">
                <label class="col-sm-3 control-label" for="route">Route</label>
                <div class="col-sm-9">
                    <input type="text" required="" class="form-control" id="route" name="route" value="{{ old('route') }}" placeholder="configs">
                    @if ($errors->has('route'))
                        <span class="help-block">
                            <strong>{{ $errors->first('route') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row form-group {{ $errors->has('icon') ? ' has-error' : '' }}">
                <label class="col-sm-3 control-label" for="icon">Icon</label>
                <div class="col-sm-9">
                    <input type="text" required="" class="form-control" id="icon" name="icon" value="{{ old('icon') }}" placeholder="fa-{user}">
                    @if ($errors->has('icon'))
                        <span class="help-block">
                            <strong>{{ $errors->first('icon') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row form-group {{ $errors->has('urutan') ? ' has-error' : '' }}">
                <label class="col-sm-3 control-label" for="urutan">urutan</label>
                <div class="col-sm-9">
                    <input type="number" required="" class="form-control" id="urutan" name="urutan" value="{{ old('urutan') }}">
                    @if ($errors->has('urutan'))
                        <span class="help-block">
                            <strong>{{ $errors->first('urutan') }}</strong>
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
          Are you sure?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <a id="deleteAnchor" href="" class='btn btn-danger'> Delete</a>
        </div>
      </div>
    </div>
  </div>
  <!-- //end of Modal Delete Confirm -->

  <!-- Edit User Modals -->
  <div class="modal fade" id="formEditModal" aria-hidden="false" aria-labelledby="formEditModalLabel" role="dialog" tabindex="-1">
  	<div  class="modal-dialog">
  		<div class="modal-content">
  			<div class="modal-header">
  				<h4 class="modal-title" id="myModalLabel">Edit {{ $title }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  			</div>
  			<div class="modal-body">
  				<form class="form-horizontal form-element" action="{{ $update_route }}" method="POST">
  					{{ csrf_field() }}
  					<input type="hidden" name="edit_id" id="edit_id" value="">
            <div class="row form-group {{ $errors->has('menu') ? ' has-error' : '' }}">
                <label class="col-sm-3 control-label" for="menu">Menu</label>
                <div class="col-sm-9">
                    <input type="text" required="" id="edit_menu" class="form-control" id="menu" name="menu" value="" placeholder="Application Configs">
                    @if ($errors->has('menu'))
                        <span class="help-block">
                            <strong>{{ $errors->first('menu') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row form-group {{ $errors->has('route') ? ' has-error' : '' }}">
                <label class="col-sm-3 control-label" for="route">Route</label>
                <div class="col-sm-9">
                    <input type="text" required="" id="edit_route" class="form-control" id="route" name="route" value="" placeholder="configs">
                    @if ($errors->has('route'))
                        <span class="help-block">
                            <strong>{{ $errors->first('route') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row form-group {{ $errors->has('icon') ? ' has-error' : '' }}">
                <label class="col-sm-3 control-label" for="icon">Icon</label>
                <div class="col-sm-9">
                    <input type="text" required="" id="edit_icon" class="form-control" id="icon" name="icon" value="" placeholder="fa-{user}">
                    @if ($errors->has('icon'))
                        <span class="help-block">
                            <strong>{{ $errors->first('icon') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row form-group {{ $errors->has('urutan') ? ' has-error' : '' }}">
                <label class="col-sm-3 control-label" for="urutan">urutan</label>
                <div class="col-sm-9">
                    <input type="number" id="edit_urutan" required="" class="form-control" id="urutan" name="urutan" value="{{ old('urutan') }}">
                    @if ($errors->has('urutan'))
                        <span class="help-block">
                            <strong>{{ $errors->first('urutan') }}</strong>
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
          var id = e.relatedTarget.value;
            document.getElementById("deleteAnchor").href = "";
          document.getElementById("deleteAnchor").href = '{{  $delete_route }}'+'/'+id;
        });

        // Edit Modal
        // --
        $('#formEditModal').on('show.bs.modal', function(e) {
          var id = e.relatedTarget.value;
            var urlDetail = '{{ $detail_route }}'+'/'+id;
            $.ajax({
                url: urlDetail,
                method: "get"
            }).done(function(data) {
                var response = $.parseJSON(data);
                document.getElementById('edit_id').value=response.id;
                document.getElementById('edit_menu').value=response.menu;
                document.getElementById('edit_route').value=response.route;
                document.getElementById('edit_icon').value=response.icon;
                document.getElementById('edit_urutan').value=response.urutan;
            });
        });

        $('#formEditModal').on('hide.bs.modal', function(e) {
		      document.getElementById('edit_id').value='';
          document.getElementById('edit_menu').value='';
          document.getElementById('edit_route').value='';
          document.getElementById('edit_icon').value='';
          document.getElementById('edit_urutan').value='';
        });

      })(document, window, jQuery);

			//get-data
	   	$(function() {
	    var table = $("#table").DataTable({
	      processing: true,
	      serverSide: true,
	      deferRender: true,
	      ajax: {
	        url: "{{ $read_route }}",
	        method: 'GET',
	      },
	columns: [
	      { data: 'no', name: 'no'},
        { data: 'menu' , name: 'menu'},
        { data: 'route' , name: 'route'},
        { data: 'icon' , name: 'icon'},
	      { data: 'urutan' , name: 'urutan'},
	      { data: 'created_by' , name: 'created_by'},
	      { data: 'action', 'searchable': false, 'orderable':false },
	      ],
	      scrollCollapse: true,

	      columnDefs: [ {
	        sortable: true
	        } ,
	        {
	          className: "text-center", "targets": [0,3]
	        },
	      ],

	      order: [[ 0, 'asc' ]],
	      fixedColumns: true

	    });

	  });
    </script>

@endsection
