@extends('layouts.app')

@php
use App\Models\Content;
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
  {!! $create_button !!}
@endsection

@section('content')
  <div  class="row">
    <div class="col-12">
      <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Manajemen {{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	<div class="table-responsive">
          <table id="table" class="table table-bordered table-striped">
						<thead>
              <tr class="primary">
                <th width="7%">No</th>
 							 @foreach ($column_title as $key => $value)
 							 	<th > {{ $value }} </th>
 							 @endforeach
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
    			<form class="form-horizontal form-element" enctype="multipart/form-data" action="{{ $create_route }}" method="POST">
    				{{ csrf_field() }}
						@foreach ($create_form as $key => $value)
							<div class="row form-group {{ $errors->has($key) ? ' has-error' : '' }}">
									<label class="col-sm-3 control-label" for="{{$key}}">{{ ucfirst($key) }}</label>
									<div class="col-sm-9">
											{{ $value }}
											@if ($errors->has($key))
													<span class="help-block">
															<strong>{{ $errors->first($key) }}</strong>
													</span>
											@endif
									</div>
							</div>
						@endforeach

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
  				<form class="form-horizontal form-element" enctype="multipart/form-data" action="{{ $update_route }}" method="POST">
  					{{ csrf_field() }}
  					<input type="hidden" name="edit_id" id="edit_id" value="">
						@foreach ($update_form as $key => $value)
							<div class="row form-group {{ $errors->has($key) ? ' has-error' : '' }}">
									<label class="col-sm-3 control-label" for="{{$key}}">{{ ucfirst($key) }}</label>
									<div class="col-sm-9">
											{{ $value }}
											@if ($errors->has($key))
													<span class="help-block">
															<strong>{{ $errors->first($key) }}</strong>
													</span>
											@endif
									</div>
							</div>
						@endforeach


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
                // console.log(urlDetail);
                // console.log(response);
                document.getElementById('edit_id').value=response.id;
								@foreach ($ajax_field[0] as $key => $value)
									@if(in_array( $key, $ajax_field[1]))
										document.getElementById('{{$value}}').value=response.{{$value}};
									@endif
								@endforeach

            });
        });

        $('#formEditModal').on('hide.bs.modal', function(e) {
					document.getElementById('edit_id').value="";
					@foreach ($ajax_field[0] as $key => $value)
						@if(in_array( $key, $ajax_field[1]))
							document.getElementById('{{$value}}').value="";
						@endif
					@endforeach
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
				@foreach ($ajax_field[0] as $key => $value)
					{ data: '{{$value}}' , name: '{{$value}}' },
				@endforeach
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
