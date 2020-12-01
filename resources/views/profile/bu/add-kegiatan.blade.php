<div class="main-sidebar">
	<div class="title">{{$tbm->nama}}</div>
	<div class="border-tbm"><span></span></div>
	<div class="detail">
		@if ( Session::get('message') != '' )
			<div class='alert alert-warning mb-20'>
				{{ Session::get('message') }}
			</div>	
		@endif
		<div class="wrapper-form">		
			<div class="title">
				<div class="ta-center">TAMBAH KEGIATAN</div>
			</div>
			<form method="post" action="{{action("FrontController@postAddKegiatan")}}" enctype="multipart/form-data">
			    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			    <div class="form-group">
			    	<label>Nama Kegiatan</label>
			    	<input type="text" name="title" class="form-control" placeholder="Nama Kegiatan">
			    </div>
			    <div class="form-group">
			    	<label>Gambar</label>
			    	<input type="file" name="image" class="form-control">
			    </div>
			    <div class="wrap-btn ta-center">
			    	<a href="{{url('profile/kegiatan')}}">Kembali</a>
			    	<input type="submit" value="Simpan">
			    </div>
			</form>
		</div>
	</div>	
</div>