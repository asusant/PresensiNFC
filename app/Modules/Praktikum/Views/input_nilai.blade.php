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
              <h3 class="box-title">Input Nilai Praktikum: <strong>{{ $praktikum->praktikum }}</strong></strong></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            	<div class="table-responsive">
          <table id="table" class="table table-bordered table-striped">
						<thead>
              <tr class="primary">
                <th width="3%">No</th>
                <th > NIM </th>
 							 	<th > Nama </th>
                <th width="22%" > Nilai </th>
              </tr>
            </thead>
            <tbody>
              <form method="POST" id="form-presensi" action="{{ $create_route }}">
                {{ csrf_field() }}
                <input type="hidden" required="" name="praktikum" value="{{ $praktikum->id }}">
              @php $no = 1; @endphp
              @foreach($pesertas as $peserta)
                <tr>
                  <td>{{ $no }}</td>
                  <td>{{ $peserta->nim }}</td>
                  <td>{{ $peserta->name }}</td>
                  <td>
                    <input type="hidden" required="" name="peserta-{{$peserta->id}}" value="{{$peserta->id}}">
                    <input type="number" name="nilai-{{$peserta->id}}" placeholder="Contoh: 86" class="form-control" required="">
                  </td>
                </tr>
                @php $no++; @endphp
              @endforeach
                <tr style="text-align: center; vertical-align: middle;">
                  <td colspan="5">
                    <a href="{{ $praktikum_route }}" class="btn btn-app bg-red">
                      <i class="fa fa-repeat"></i>
                      Batal
                    </a>
                    <button id="btnComplete" class="btn btn-app bg-teal">
                      <i class="fa fa-save"></i>
                      Simpan
                    </button>
                  </td>
                </tr>
              </form>
            </tbody>
         </table>
          </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
  </div>

  <div class="modal fade" id="konfirmasi-presensi" aria-hidden="false" aria-labelledby="adduserModalLabel" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-center" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Presensi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <center>
            <div class="alert alert-danger" role="alert">
              <span id="pesan">Apakah Anda telah selesai melakukan penilaian? *Data Penilaian tidak dapat diubah setelah disimpan!</span>
            </div>
          </center>
        </div>
        <div class="modal-footer ">
          <button id="submit" class="btn btn-danger "> Ya</button>
          <button type="button" class="btn btn-secondary  pull-right" data-dismiss="modal">Belum</button>
        </div>
      </div>
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

      (function(document, window, $) {

          $('#btnComplete').on('click', function(e) {
              var $myForm = $('#form-presensi');

              if($myForm[0].checkValidity()) {
                  e.preventDefault();
                  $('#konfirmasi-presensi').modal('toggle');
              }
          });

          $('#submit').on('click', function(event) {
              $('#form-presensi').submit();
          });

      })(document, window, jQuery);

    </script>

@endsection
