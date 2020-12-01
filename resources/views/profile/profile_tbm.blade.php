@extends('layouts')
@section('content')
<?php 
	$type = DB::table('master_tbm')->where('id',$tbm->id_master_tbm)->first();
?>
<!-- content -->
<div class="bg-white">
	<div class="box-container" id="box-container">
		<div class="col-sm-12">
			<div class="title-content">
				<h1>{{$tbm->nama}}</h1>
				<div class="center-line"></div>
			</div>
		</div>

		<div class="container">
			<div class="col-sm-4">
				<div class="sidebar">
					<div class="img-side-kegiatan" style="background-image: url('{{asset($tbm->image)}}');"></div>
					@if($id_tbm)
					<div class="list-group kegiatan m-t-30">
						<a href="{{url('/tbm/'.Crypt::encrypt($id_tbm))}}" class="list-group-item {{($slug=='')?'active':''}}">Profile <span class="pull-right"> <i class="fas fa-chevron-right"></i> </span></a>
						<a href="{{url('/tbm/'.Crypt::encrypt($id_tbm).'/kegiatan')}}" class="list-group-item {{($slug=='kegiatan')?'active':''}}">Kegiatan TBM <span class="pull-right"> <i class="fas fa-chevron-right"></i> </span></a>
						<a href="{{url('/tbm/'.Crypt::encrypt($id_tbm).'/kebutuhan')}}" class="list-group-item {{($slug=='kebutuhan')?'active':''}}">Daftar Kebutuhan Buku <span class="pull-right"> <i class="fas fa-chevron-right"></i> </span></a>						
					</div>
					@else
					<div class="list-group kegiatan m-t-30">
						<a href="{{url('/profile')}}" class="list-group-item {{($slug=='')?'active':''}}">Profile <span class="pull-right"> <i class="fas fa-chevron-right"></i> </span></a>
						<a href="{{url('/profile/kegiatan')}}" class="list-group-item {{($slug=='kegiatan')?'active':''}}">Kegiatan TBM <span class="pull-right"> <i class="fas fa-chevron-right"></i> </span></a>
						<a href="{{url('/profile/kebutuhan')}}" class="list-group-item {{($slug=='kebutuhan')?'active':''}}">Daftar Kebutuhan Buku <span class="pull-right"> <i class="fas fa-chevron-right"></i> </span></a>
						<a href="{{url('/profile/pemberitahuan')}}" class="list-group-item {{($slug=='pemberitahuan')?'active':''}}">Tanda terima buku
							@if(count($info) > 0)
							<span class="badge red">{{count($info)}}</span> 
							@else
							<span class="pull-right"> <i class="fas fa-chevron-right"></i> </span>
							@endif
						</a>
					</div>
					<a href="{{url('/logout')}}" class="btn btn-default white btn-block menu-custom">Keluar</a>
					@endif
				</div>
			</div>
			@if($slug != '')
				@include('profile.'.$slug)
			@else
			<div class="col-sm-8">
				<h2 class="pull-left">PROFIL TBM</h2>
				@if($id_tbm)
				<h4 class="pull-right m-t-30">{{$type->name}}</h4>
				@else
				<button class="btn btn-default yellow menu-login custom-menu menu-custom pull-right m-t-10" type="button" data-toggle="modal" data-target="#modal-description">Edit Deskripsi</button> <a href="{{url('profile/edit')}}"><button class="btn btn-default white menu-login custom-menu menu-custom pull-right m-t-10"  style="margin-right: 10px;" type="button">Edit Profile</button></a>
				@endif
				<hr class="clear">
				<div class="row prifle-content">
					<div class="col-sm-6">
						<h6>Nama Pengelola</h6>
						<h4>{{$tbm->nama_ketua}}</h4>
					</div>
					<div class="col-sm-6">
						<h6>Email Pengelola</h6>
						<h4>{{$tbm->email_pengelola}}</h4>
					</div>
					<div class="col-sm-6">
						<h6>Tahun Berdiri</h6>
						<h4>{{$tbm->tahun_berdiri}}</h4>
					</div>
					<div class="col-sm-6">
						<h6>No Ijin Oprasional</h6>
						<h4>{{$tbm->no_izin}}</h4>
					</div>
					<div class="col-sm-6">
						<h6>Provinsi</h6>
						<h4>{{show_value($tbm->provinsi,'propinsi','propinsi')}}</h4>
					</div>
					<div class="col-sm-6">
						<h6>Kab / Kota</h6>
						<h4>{{show_value($tbm->kota,'kabupaten','kabupaten')}}</h4>
					</div>
					<div class="col-sm-12">
						<h6>Jalan</h6>
						<h4>{{$tbm->alamat}}</h4>
					</div>
					<div class="col-sm-12">
						<h6>Kode Pos</h6>
						<h4>{{$tbm->kodepos}}</h4>
					</div>
					<div class="col-sm-12">
						<h6>Email</h6>
						<h4>{{$tbm->email}}</h4>
					</div>
					<div class="col-sm-12">
						<h6>Tentang TBM</h6>
						<h4>@if(empty($tbm->description)) Belum dilengkapi @else {{$tbm->description}} @endif</h4>
					</div>
					<div class="col-sm-12">
						<h6>Alamat Website</h6>
						<h4>@if(empty($tbm->description)) Belum dilengkapi @else <a href="{{$tbm->url_website}}" target="_blank">{{$tbm->url_website}}</a> @endif</h4>
					</div>
					<div class="col-sm-6">
						<h6>Facebook</h6>
						<h4>@if(empty($tbm->description)) Belum dilengkapi @else <a href="{{$tbm->facebook}}" target="_blank">{{$tbm->facebook}}</a> @endif</h4>
					</div>
					<div class="col-sm-6">
						<h6>Twitter</h6>
						<h4>@if(empty($tbm->description)) Belum dilengkapi @else <a href="{{$tbm->twitter}}" target="_blank">{{$tbm->twitter}}</a> @endif</h4>
					</div>
					<div class="col-sm-6">
						<h6>Google Plus</h6>
						<h4>@if(empty($tbm->description)) Belum dilengkapi @else <a href="{{$tbm->gplus}}" target="_blank">{{$tbm->gplus}}</a> @endif</h4>
					</div>
					<div class="col-sm-6">
						<h6>Instagram</h6>
						<h4>@if(empty($tbm->description)) Belum dilengkapi @else <a href="{{$tbm->instagram}}" target="_blank">{{$tbm->instagram}}</a> @endif</h4>
					</div>
					<div class="col-sm-12">
						<h6>Map</h6>
						@if($tbm->latitude && $tbm->longitude)
						<div id="map"></div>
						@endif
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
<?php
    $Lat = $tbm->latitude;
    $Lon = $tbm->longitude;
?>
<!-- Modal -->
<div id="modal-description" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tentang TBM</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{action('FrontController@postEditTentang')}}">
        	<div class="form-group">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	        	<label>Deskripsi singkat tentang TBM</label>
	        	<textarea class="form-control" rows="4" name="description">{!!$tbm->description!!}</textarea>
	        </div>
	        <div class="form-group">
	        	<label>Alamat website</label>
	        	<input type="url" name="url_website" value="{{$tbm->url_website}}" class="form-control">
	        </div>
	        <h4><b>Sosial Media</b></h4>
	        <div class="form-group">
	        	<label>Facebook</label>
	        	<input type="url" name="facebook" value="{{$tbm->facebook}}" class="form-control">
	        </div>
	        <div class="form-group">
	        	<label>Twitter</label>
	        	<input type="url" name="twitter" value="{{$tbm->twitter}}" class="form-control">
	        </div>
	        <div class="form-group">
	        	<label>Google Plus</label>
	        	<input type="url" name="gplus" value="{{$tbm->gplus}}" class="form-control">
	        </div>
	        <div class="form-group">
	        	<label>Instagram</label>
	        	<input type="url" name="instagram" value="{{$tbm->instagram}}" class="form-control">
	        </div>
	        <div class="form-group">
	        	<button type="submit" class="btn btn-success">Simpan</button>
	        </div>
        </form>
      </div>
    </div>

  </div>
</div>
@push('js')
<script>
	function initMap() {
        // var myLatLng = {lat: -25.363, lng: 131.044};
        var myLatLng = {lat: <?php echo $Lat ?>, lng: <?php echo $Lon ?>};

        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('map'), {
        	center: myLatLng,
        	scrollwheel: false,
        	zoom: 15
        });

        // Create a marker and set its position.
        var marker = new google.maps.Marker({
        	map: map,
        	position: myLatLng
        });
    }

</script>
@if(Request::segment(2) == '')
<script src="https://maps.googleapis.com/maps/api/js?key={{get_setting('google_api_key')}}&callback=initMap" async defer></script><br>
@endif
@endpush
@endsection