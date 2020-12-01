@extends('layouts')
@section('content')
<?php
	// $tbm = array_unique($tbm);
?>
<div class="container box-container" id="box-container">
	<div class="col-sm-8 col-sm-offset-2 m-t-50">

		<div class="wrapper-register">
			<div class="title-register"><h4 class="color-blue">Informasi Pengiriman</h4><h4>No Donasi : {{$no_donasi}}</h4></div>
			<div class="col-sm-10 col-sm-offset-1">
				<div class="row prifle-content info-pengiriman">
					@foreach($tbm as $row)
					<?php 
						$info = DB::Table('tbm')->where('id',$row->id_tbm)->first(); 
						$kategori = DB::Table('donasi_item')->where('id_donasi',$id_donasi_nya)->where('id_tbm',$row->id_tbm)->get();
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
				<center><button class="btn btn-default menu-login blue" type="button" onclick="InsertTestimony()">Beri Komentar</button></center>
			</div>
		</div>
	</div>
</div>
@push('js')
<script type="text/javascript">
	function InsertTestimony(){
      $('#testimoni').modal('show'); 
    }
</script>
@endpush
<!-- Modal -->
<div id="testimoni" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
      	<div class="modal-body-custom">
			<form method="post" action="{{action('FrontController@postTestimony')}}" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="col-md-12">
				<h5>No Donasi : {{$no_donasi}}</h5>
				<p>Terima kasih, masukan dan saran sangat kami butuhkan untuk pengembangan Donasi buku ini</p>
				<div class="m-t-50">
					<input type="hidden" name="id_donasi" value="{{$id_donasi_nya}}">
					<fieldset class="float-label">
						<input name="testimony" class="form-control" autocomplete="off" type="text"  required placeholder=".........." />
						<!-- <label for="username">Berikan komentar</label> -->
						<hr class="border border-no-padding m-tb-0">
					</fieldset>
				</div>
				<button type="submit" class="btn btn-default custom-menu blue">Kirim</button>
				</div>
			</form>
      	</div>
      </div>
    </div>

  </div>
</div>
@endsection