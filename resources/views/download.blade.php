@extends('layouts')
@section('content')
<!-- content -->
<div class="bg-white">
	<div class="box-container" id="box-container">
		<div class="title-content">
			<h1>Unduh</h1>
			<div class="center-line"></div>
			<p class="m-t-20">Silahkan unduh beberapa dokumen yang anda perlukan</p>
		</div>

		<div class="container">
			<div class="col-md-6 col-md-offset-3">
				<div class="list-group">
				@foreach($download as $row)
				  <a href="{{asset($row->file)}}"  download="" target="_Blank" class="list-group-item list-group-custom">{{$row->nama_file}} <span class="btn btn-success blue btn-xs pull-right"><i class="fas fa-download"></i></span> </a>
				@endforeach
				<center>@include('pagination.default', ['paginator' => $download])</center>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection