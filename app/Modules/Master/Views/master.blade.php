@extends('layouts.app')

@php
use App\Modules\Barang\Models\Content;
@endphp

@section('title')
  {{ $title }} | {{Content::content('site-name')}}
@endsection

@section('extra-css')
  	
@endsection

@section('content-header')
 	{{ $title }}
@endsection

@section('content-header-right')
  <button class="btn btn-sm btn-default" data-target="#add" data-toggle="modal">
    <i class="icon wb-plus" aria-hidden="true"></i>
    <span class="hidden-xs">Tambah {{ $title }}</span>
  </button>
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
               <th >Level</th>
               <th >Dibuat pada</th>
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
						<div class="row form-group {{ $errors->has('level') ? ' has-error' : '' }}">
								<label class="col-sm-3 control-label" for="level">Level</label>
								<div class="col-sm-9">
										<input type="text" required="" class="form-control" id="level" name="level" value="{{ old('level') }}" placeholder="God">
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
  <div class="modal fade" id="formEditAgentModal" aria-hidden="false" aria-labelledby="formEditAgentModalLabel" role="dialog" tabindex="-1">
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
		            <div class="row form-group {{ $errors->has('edit_level') ? ' has-error' : '' }}">
		                <label class="col-sm-3 control-label" for="edit_level">Level</label>
		                <div class="col-sm-9">
		                    <input type="text" required="" class="form-control" id="edit_level" name="edit_level" value="{{ old('edit_level') }}" placeholder="God">
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
          var id = e.relatedTarget.value;
            document.getElementById("deleteAnchor").href = "";
          document.getElementById("deleteAnchor").href = '{{  $delete_route }}'+'/'+id;
        });

        // Edit Modal
        // --
        $('#formEditAgentModal').on('show.bs.modal', function(e) {
          var id = e.relatedTarget.value;
            var urlDetail = '{{ $detail_route }}'+'/'+id;
            $.ajax({
                url: urlDetail,
                method: "get"
            }).done(function(data) {
                var response = $.parseJSON(data);
                console.log(urlDetail);
                console.log(response);
                document.getElementById('edit_id').value=response.id;
                document.getElementById('edit_level').value=response.level;

            });
        });

        $('#formEditAgentModal').on('hide.bs.modal', function(e) {
					document.getElementById('edit_id').value="";
					document.getElementById('edit_level').value="";
        });

      })(document, window, jQuery);

			//get-data
	   	$(function() {
	    var table = $("#table").DataTable({
	      processing: true,
	      serverSide: true,
	      deferRender: true,
	      ajax: {
	        url: "{{ $request_route }}",
	        method: 'GET',
	      },
	columns: [
	      { data: 'no', name: 'no'},
	      { data: 'level' , name: 'level'},
	      { data: 'created_at' , name: 'created_at'},
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
