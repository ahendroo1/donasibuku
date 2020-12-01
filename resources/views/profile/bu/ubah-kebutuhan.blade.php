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
				<div class="ta-center">UBAH PERMINTAAN BUKU</div>
			</div>
			<form method="post" action="{{action("FrontController@postUbahKebutuhan")}}" enctype="multipart/form-data">
			    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			    <input type="hidden" name="id" value="{{$kebutuhan->id}}" />
			    <div class="form-group">
			    	<label>Judul Buku</label>
			    	<input type="text" name="judul" class="form-control" placeholder="Judul Buku" value="{{$kebutuhan->judul}}">
			    </div>
			    <div class="form-group">
			    	<label>Kategori</label>
			    	<select class="form-control" name="id_kategori_buku">
			    		<option value="">- Pilih Kategori -</option>
			    		@foreach($kategori_buku as $item)
			    			<option value="{{$item->id}}" {{($kebutuhan->id_kategori_buku == $item->id)?"selected='selected'":""}}>{{$item->nama}}</option>
			    		@endforeach
			    	</select>
			    </div>
			    <div class="form-group">
			    	<label>Penerbit</label>
			    	<input type="text" name="penerbit" class="form-control" placeholder="Penerbit" value="{{$kebutuhan->penerbit}}">
			    </div>
			    <div class="form-group">
			    	<label>Toko Buku</label>
			    	<input type="text" name="toko_buku" class="form-control" placeholder="Toko Buku" value="{{$kebutuhan->toko_buku}}">
			    </div>
			    <div class="form-group">
			    	<label>Pengarang</label>
			    	<input type="text" name="pengarang" class="form-control" placeholder="Pengarang" value="{{$kebutuhan->pengarang}}">
			    </div>
			    <div class="form-group">
			    	<label>Harga</label>
			    	<input type="text" name="harga" class="form-control" placeholder="Harga" value="{{$kebutuhan->harga}}">
			    </div>
			    <div class="wrap-btn ta-center">
			    	<a href="{{url('profile/kebutuhan')}}">Kembali</a>
			    	<input type="submit" value="Simpan">
			    </div>
			</form>
		</div>
	</div>	
</div>