@extends('layouts.app')

@section('title')
	Normal Table
@endsection

@section('extra-css')
	<!-- Plugin -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables-fixedheader/dataTables.fixedHeader.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/datatables-responsive/dataTables.responsive.css') }}">
@endsection

@section('extra-css-inline')
	<style>
		@media (max-width: 480px) {
			.panel-actions .dataTables_length {
				display: none;
			}
		}

		@media (max-width: 320px) {
			.panel-actions .dataTables_filter {
				display: none;
			}
		}

		@media (max-width: 767px) {
			.dataTables_length {
				float: left;
			}
		}

		#exampleTableAddToolbar {
			padding-left: 30px;
		}
	</style>
@endsection

@section('content')

	<!-- Page -->
	<div class="page animsition">
		<div class="page-header">
			<h1 class="page-title">DataTables</h1>
			<ol class="breadcrumb">
				<li><a href="../index.html">Home</a></li>
				<li><a href="javascript:void(0)">Tables</a></li>
				<li class="active">DataTables</li>
			</ol>
			<div class="page-header-actions">
				<a class="btn btn-sm btn-default btn-outline btn-round" href="http://datatables.net"
				target="_blank">
					<i class="icon wb-link" aria-hidden="true"></i>
					<span class="hidden-xs">Official Website</span>
				</a>
			</div>
		</div>
		<div class="page-content">
			<!-- Panel Basic -->
			<div class="panel">
				<header class="panel-heading">
					<div class="panel-actions"></div>
					<h3 class="panel-title">Basic</h3>
				</header>
				<div class="panel-body">
					<table class="table table-hover dataTable table-striped width-full" data-plugin="dataTable" id="tableNormal">
						<thead>
							<tr>
								<th>Name</th>
								<th>Position</th>
								<th>Office</th>
								<th>Age</th>
								<th>Date</th>
								<th>Salary</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Name</th>
								<th>Position</th>
								<th>Office</th>
								<th>Age</th>
								<th>Date</th>
								<th>Salary</th>
							</tr>
						</tfoot>
						<tbody>
							<tr>
								<td>Damon</td>
								<td>5516 Adolfo Green</td>
								<td>Littelhaven</td>
								<td>85</td>
								<td>2014/06/13</td>
								<td>$553,536</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
	</div>
</div>

@endsection

@section('extra-js')
	<!-- Plugins -->
  <script src="{{ asset('assets/vendor/switchery/switchery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/intro-js/intro.js') }}"></script>
  <script src="{{ asset('assets/vendor/screenfull/screenfull.js') }}"></script>
  <script src="{{ asset('assets/vendor/slidepanel/jquery-slidePanel.js') }}"></script>

  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-fixedheader/dataTables.fixedHeader.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-bootstrap/dataTables.bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables-tabletools/dataTables.tableTools.js') }}"></script>
@endsection

@section('extra-js-inline')
	<script>
    (function(document, window, $) {
      'use strict';

      var Site = window.Site;

      $(document).ready(function($) {
        Site.run();
      });

      // Fixed Header Example
      // --------------------
      (function() {
        // initialize datatable
        var table = $('#tableNormal').DataTable({
          responsive: true,
          // "bPaginate": false,
          // "sDom": "t" // just show table, no other controls
        });

        // initialize FixedHeader
        var offsetTop = 0;
        if ($('.site-navbar').length > 0) {
          offsetTop = $('.site-navbar').eq(0).innerHeight();
        }
        var fixedHeader = new FixedHeader(table, {
          offsetTop: offsetTop
        });

        // redraw fixedHeaders as necessary
        $(window).resize(function() {
          fixedHeader._fnUpdateClones(true);
          fixedHeader._fnUpdatePositions();
        });
      })();

    })(document, window, jQuery);
  </script>
@endsection
