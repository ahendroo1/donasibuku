@extends('layouts')
@section('content')
<?php 
	$master_tbm = DB::Table('master_tbm')->orderby('name','asc')->get(); 
	$type = DB::Table('master_tbm')->where('id',Request::get('type'))->first(); 
?>
<!-- content -->
<div class="bg-white bg-list-kabupaten">
	<div class="box-container" id="box-container">
		<div class="title-content">
			<h1>Kabupaten {{$kota}}</h1>
			<div class="center-line"></div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-9 col-xs-6">
					<form>
						<div class="btn-group btn-group-custom">
							<button type="button" class="btn btn-primary btn-transparant dropdown-toggle" data-toggle="dropdown">
								<span class="m-r-70">@if(!empty(Request::get('type'))) {{$type->name}} @else Semua Type @endif</span> <span class="caret"></span></button>
								<ul class="dropdown-menu" role="menu">
									@foreach($master_tbm as $row)
									<li><a href="?provinsi={{Request::get('provinsi')}}&kota={{Request::get('kota')}}&type={{$row->id}}&q={{Request::get('q')}}">{{$row->name}}</a></li>
									@endforeach
								</ul>
							</div>
						</form>
					</div>
					<div class="col-md-3 col-xs-6">
						<form method="get" action="">
							<div class="group-search pull-right">
								<input type="hidden" name="provinsi" value="{{Request::get('provinsi')}}">
								<input type="hidden" name="kota" value="{{Request::get('kota')}}">
								<input type="text" name="q" class="form-control radius" placeholder="Cari..." value="{{Request::get('q')}}">
								<i class="fas fa-search icon-search"></i>
							</div>
						</form>
					</div>
					<div class="clear"></div>
					<div class="col-sm-8">
						<div class="m-t-20">
							@if(count($tbm) == 0)
					        <center>
					          <div style="font-size: 50px;">Maaf </div>
					          <h4>TBM yang anda maksud tidak ditemukan.</h4>
					        </center>
					        @endif
							@foreach($tbm as $item)
							<?php $type_tbm = DB::Table('master_tbm')->where('id',$item->id_master_tbm)->first(); ?>
							<div class="list-data-kabupaten">
								<a href="{{url('tbm/'.Crypt::encrypt($item->id))}}">
									<h4>{{$item->nama}}</h4>
									<p>{{$type_tbm->name}}</p>
									<p class="alamat-data">{{$item->alamat}}</p>
								</a>
							</div>
							@endforeach
						</div>
						<div class="m-t-20">
							<center>@include('pagination.default', ['paginator' => $tbm])</center>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="sidebar list-kabupaten">
							@include('sidebar')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection