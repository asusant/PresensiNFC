@extends('layouts.app')

@section('title')
	Dashboard | {{ App\Models\Content::content('site-name')}}
@endsection

@section('content')
	{{-- <div class="row"> --}}
		<div class="jumbotron ">
			<div class="container" style="padding:50px">
				<h1 class="display-4">Selamat Datang <b>{{ $user->name }}!</b></h1>
				<p class="lead">Anda masuk sebagai <u> {{ $level->level }} </u></p>
				<hr class="my-4">
			</div>
		</div>
	{{-- </div> --}}

@endsection

@section('extra-js')

    <script>
	  $.widget.bridge('uibutton', $.ui.button);
	</script>
@endsection
