<div class="col-sm-8">
	<h2 class="pull-left">Kegiatan TBM</h2>
	<hr class="clear">
	<form method="post" action="{{action("FrontController@postAddKebutuhan")}}" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div class="m-t-40">
			<fieldset class="float-label">
				<input name="judul" class="form-control" autocomplete="off" type="text"  required />
				<label for="username">Judul Buku</label>
				<hr class="border border-no-padding m-tb-0">
			</fieldset>
			<div class="m-t-30">
				<div class="form-group form-group-custom" style="margin-top: 18px;">
					<label>Kategori</label>
					<select class="form-control" id="kategori" name="id_kategori_buku">
						<option value="">*Pilih Kategori</option>
						@foreach($kategori_buku as $item)
			    			<option value="{{$item->id}}">{{$item->nama}}</option>
			    		@endforeach
					</select>
					<hr class="border border-no-padding  m-tb-0">
				</div>
			</div>
			<fieldset class="float-label">
				<input name="penerbit" class="form-control" autocomplete="off" type="text"  required />
				<label for="username">Penerbit</label>
				<hr class="border border-no-padding m-tb-0">
			</fieldset>
			<fieldset class="float-label">
				<input name="toko_buku" class="form-control" autocomplete="off" type="text"  required />
				<label for="username">Toko Buku</label>
				<hr class="border border-no-padding m-tb-0">
			</fieldset>
			<fieldset class="float-label">
				<input name="pengarang" class="form-control" autocomplete="off" type="text"  required />
				<label for="username">Pengarang</label>
				<hr class="border border-no-padding m-tb-0">
			</fieldset>
			<fieldset class="float-label">
				<input name="harga" class="form-control" autocomplete="off" type="bumber"  required />
				<label for="username">Harga</label>
				<hr class="border border-no-padding m-tb-0">
			</fieldset>
			<div class="m-t-30">
		    	<a href="{{url('profile/kebutuhan')}}" class="btn-default menu-login grey sm-default">Kembali</a>
		    	<button class="btn btn-default menu-login white" type="submit">Simpan</button>
		    </div>
		</div>
	</form>
</div>