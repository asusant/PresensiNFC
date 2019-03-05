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

  <!-- Modal Delete Confirm -->
  <div class="modal fade" id="confirmAktifModal" tabindex="-1" role="dialog" aria-labelledby="confirmAktifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-center" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmAktifModalLabel">Konfirmasi Aktif</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin akan mengaktifkan Praktikum tersebut?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <a id="aktifAnchor" href="" class='btn btn-danger'> Ya</a>
        </div>
      </div>
    </div>
  </div>
  <!-- //end of Modal Delete Confirm -->

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
        $('#confirmAktifModal').on('show.bs.modal', function(e) {
          var id = e.relatedTarget.value;
            document.getElementById("aktifAnchor").href = "";
          document.getElementById("aktifAnchor").href = '{{  $aktif_route }}'+'/'+id;
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
