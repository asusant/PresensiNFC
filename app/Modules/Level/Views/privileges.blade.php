@extends('layouts.app')

@php
use App\Models\Content;
@endphp

@section('title')
  {{ $title }} | {{Content::content('site-name')}}
@endsection

@section('extra-css')
  	<link rel="stylesheet" href="{{ asset('assets/newassets/assets/vendor_components/bootstrap-switch/switch.css') }}">
    <style type="text/css">
      .btn-toggle:before {
        content: 'No' !important;
        left: -4rem;
      }
      .btn-toggle:after {
        content: 'Yes' !important;
        right: -4rem;
        opacity: .5;
      }
    </style>
@endsection

@section('content-header')
 	{{ $title }}
@endsection

@section('content-header-right')
  <a class="btn btn-sm btn-default" href="{{ $level_route}}">
    <i class="fa fa-arrow-left" aria-hidden="true"></i>
    <span class="hidden-xs">Back to User levels</span>
  </a>
@endsection

@section('content')
  <div  class="row">
    <div class="col-12">
      <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> {{ $title }} Untuk <strong> {{ $level->level }} </strong> </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	<div class="table-responsive">
          <table id="table" class="table table-bordered table-striped">
           <thead>
             <tr class="primary">
               <th width="7%">No</th>
               <th >Menu</th>
               <th >Read</th>
               <th >Create</th>
               <th >Update</th>
               <th >Delete</th>
               <th >Validate</th>
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

@endsection

@section('extra-js')
  <link href="{{ asset('assets/newassets/assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.css') }}" rel="stylesheet">
  <!-- DataTables -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/newassets/assets/vendor_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
  <!-- This is data table -->
  <script src="{{ asset('assets/newassets/assets/vendor_plugins/DataTables-1.10.15/media/js/jquery.dataTables.min.js') }}"></script>
  <!-- MinimalPro Admin for Data Table -->
  <script src="{{ asset('assets/newassets/js/pages/data-table.js') }}"></script>
  <!-- Toast -->
  <script src="{{ asset('assets/newassets/assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js') }}"></script>
@endsection

@section('extra-js-inline')
    <script>

      (function(document, window, $) {

        // Post Switch Access
        // --

        $(document).on('click','#change',function(e){
          //window.alert("Clicked Priv. "+$(this).attr('id-privilege')+" | Menu "+$(this).attr('id-menu')+" | Level "+$(this).attr('id-level')+" | State "+$(this).attr('aria-pressed'));
          $.ajax({
              url: '{{ url('level/privilege') }}'+'/'+$(this).attr('param')+'/'+$(this).attr('id-level')+'/'+$(this).attr('id-menu')+'/'+$(this).attr('aria-pressed'),
              method: "get",
          })
          .fail(function() {
            $.toast({
                heading: 'Failed',
                text: 'Failed to save Your change. We recommend You to reload this page before do another changes',
                position: 'top-right',
                loaderBg: '#fc4b6c',
                icon: 'error',
                hideAfter: 9000,
                stack: 10
            });
          })
          .done(function(data) {
            var response = $.parseJSON(data);

            $.toast({
                heading: 'Success',
                text: 'Your change has been successfuly saved.',
                position: 'top-right',
                loaderBg: '#26c6da',
                icon: 'success',
                hideAfter: 1500,
                stack: 10
            });
            
          });

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
	      { data: 'menu' , name: 'menu'},
	      { data: 'read' , name: 'read'},
        { data: 'create' , name: 'create'},
        { data: 'update' , name: 'update'},
        { data: 'delete' , name: 'delete'},
	      { data: 'validate' , name: 'validate'},
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