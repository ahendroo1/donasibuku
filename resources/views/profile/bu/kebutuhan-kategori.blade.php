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
				<div class="ta-center">TAMBAH PERMINTAAN BUKU</div>
			</div>
			<form method="post" action="{{action("FrontController@postAddKebutuhanKtg")}}" enctype="multipart/form-data">
			    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			    <input type="hidden" name="id_kategori_buku" value="{{ $id_kategori_buku }}" />
				<div class="desk ta-center mb-20 mt-10">Anda Yakin Akan Menambahkan Kebutuhan Buku<br>Hanya Berdasarkan Kategori Buku Saja?</div>
				<div class="wrap-btn ta-center">
					<a href="{{url('profile/add-kebutuhan')}}">Tidak</a>
					<input type="submit" value="Ya">
				</div>
			</form>
		</div>
	</div>	
</div>