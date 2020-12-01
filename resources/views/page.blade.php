@extends('layouts')
@section('content')
<!-- content -->
<div class="bg-white">
	<div class="box-container" id="box-container">
		<div class="title-content">
			<h1>{{$page->title}}</h1>
			<div class="center-line"></div>
		</div>

		<div class="container">
			<div class="col-sm-7">
				<div class="list-berita-page">
					<!-- <div class="berita-img" style="background-image: url('{{asset('assets/bg/bg_daftar_tbm.png')}}');"></div> -->
					<!-- <h3>{{$page->title}}</h3> -->
					<p>{!!$page->content!!}</p>
				</div>
			</div>
			<div class="col-sm-4 col-md-offset-1">
				<div class="sidebar">
					<form method="get" action="{{url('artikel')}}">
						<div class="group-search">
							<input type="text" name="q" class="form-control radius" placeholder="Cari..." value="{{Request::get('q')}}">
							<i class="fas fa-search icon-search"></i>
						</div>
					</form>
					@include('sidebar')
				</div>
			</div>
		</div>
	</div>
</div>
@endsection