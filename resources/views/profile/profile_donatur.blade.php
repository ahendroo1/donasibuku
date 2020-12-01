@extends('layouts')
@section('content')
<!-- content -->
<div class="bg-white">
	<div class="box-container" id="box-container">
		<div class="col-sm-12">
			<div class="title-content">
				<h1>{{$donatur->nama}}</h1>
				<div class="center-line"></div>
			</div>
		</div>

		<div class="container">
			<div class="col-sm-4">
				<div class="sidebar">
					<!-- <div class="img-side-kegiatan" style="background-image: url('{{asset($tbm->image)}}');"></div> -->
					<div class="list-group kegiatan">
						<a href="{{url('/profile')}}" class="list-group-item {{($slug=='')?'active':''}}">Profile <span class="pull-right"> <i class="fas fa-chevron-right"></i> </span></a>
						<a href="{{url('/profile/donasi-buku')}}" class="list-group-item {{($slug=='donasi-buku')?'active':''}}">Donasi Buku <span class="pull-right"> <i class="fas fa-chevron-right"></i> </span></a>
						<a href="{{url('/profile/riwayat-donasi')}}" class="list-group-item {{($slug=='riwayat-donasi')?'active':''}}">Riwayat Donasi <span class="pull-right"> <i class="fas fa-chevron-right"></i> </span></a>
					</div>
					<a href="{{url('/logout')}}" class="btn btn-default white btn-block menu-custom">Keluar</a>
				</div>
			</div>
			@if($slug != '')
				@include('profile.'.$slug)
			@else
			<div class="col-sm-8">
			<h2 class="pull-left">Profile Donatur</h2>
			<a href="{{url('profile/edit')}}"><button class="btn btn-default white menu-login custom-menu menu-custom pull-right m-t-10" type="button">Edit Profile</button></a>
			<hr class="clear">
			<div class="row prifle-content">
			  <div class="col-sm-12">
			    <h6>Instansi</h6>
			    <h4>{{$donatur->instansi}}</h4>
			  </div>
			  <div class="col-sm-6">
			    <h6>No Telepon</h6>
			    <h4>{{$donatur->tlpn}}</h4>
			  </div>
			  <div class="col-sm-6">
			    <h6>Email</h6>
			    <h4>{{$donatur->email}}</h4>
			  </div>
			  <div class="col-sm-12">
			    <h6>Jalan</h6>
			    <h4>{{$donatur->alamat}}</h4>
			  </div>
			</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection