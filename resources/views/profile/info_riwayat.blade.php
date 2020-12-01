@extends('layouts')
@section('content')
<div class="container box-container" id="box-container">
	<div class="col-sm-8 col-sm-offset-2 m-t-50">

		<div class="wrapper-register">
			<div class="title-register"><h4 class="color-blue">Informasi Pengiriman</h4><h4>No Donasi : {{$no_donasi}}</h4></div>
			<div class="col-sm-10 col-sm-offset-1">
				<div class="row prifle-content info-pengiriman">
					@foreach($tbm as $row)
					<?php 
						$info = DB::Table('tbm')->where('id',$row->id_tbm)->first(); 
						$kategori = DB::Table('donasi_item')->where('id_donasi',$id_donasi_nya)->get();
					?>
					<div class="col-md-12">
						<h6>Nama TBM</h6>
						<p>{{$info->nama}}</p>
					</div>
					<div class="col-md-12">
						<h6>Penerima</h6>
						<p class="pull-left">{{$info->nama_ketua}}</p>
						<a href="{{url('print-alamat')}}?id_tbm={{$row->id_tbm}}&id_donasi={{$id_donasi_nya}}" class="btn menu-login custom-menu menu-custom yellow btn-xs pull-right btn-print" target="_blank">Print Alamat</a>
					</div>
					<div class="col-md-12 clear">
						<h6>Alamat</h6>
						<p>{{$info->alamat}}</p>
					</div>
					<div class="col-md-12">
						<h6>Kategori Buku</h6>
						<p>
							@foreach($kategori as $row)
								<?php $getkategori = DB::Table('kategori_buku')->where('id',$row->id_kategori_buku)->first();  ?>
								{{$getkategori->nama}},
							@endforeach
						</p>
					</div>
					<hr class="clear">
					@endforeach
					<div class="col-md-12">
						<h5>Informasi Tata Cara Donasi</h5>
						<p class="f-grey">1. Print / catat informasi pengiriman di atas untuk di tempel pada paket pengiriman. <br>2. Paket bisa di kirim melalui kurir apapun, jika mengunakan POS indonesia paket donasi tersebut tidak di kenakan biaya <br>3. Mohon untuk mengisi form komentar</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection