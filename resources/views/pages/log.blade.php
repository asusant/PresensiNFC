@extends('layouts.app')

@section('title')
  Log Aktivitas | | {{ App\Models\Content::content('site-name')}}
@endsection

@section('extra-css')
  	
@endsection

@section('content-header')
  Log Aktivitas
@endsection

@section('content')
  <div  class="row">
    <div class="col-12">
      <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Log Aktivitas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table" class="table table-bordered table-responsive">
                <thead>
                  <tr class="primary">
                    <th width="10%">No</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Waktu</th>
                  </tr>
                </thead>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>

  </div>

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

			//get-data
	   	$(function() {
	    var table = $("#table").DataTable({
	      processing: true,
	      serverSide: true,
	      deferRender: true,
	      ajax: {
	        url: "{{ route('log.get-data.read') }}",
	        method: 'GET',
	      },
	columns: [
	      { data: 'no', name: 'no'},
	      { data: 'name' , name: 'users.name'},
	      { data: 'aktivitas' , name: 'log.aktivitas'},
	      { data: 'created_at' , name: 'log.created_at'},
	      ],
	      scrollCollapse: true,

	      columnDefs: [ {
	        sortable: true
	        } ,
	        {
	          className: "text-center", "targets": [0]
	        },
	      ],

	      order: [[ 0, 'asc' ]],
	      fixedColumns: true

	    });

	  });
    </script>

@endsection
