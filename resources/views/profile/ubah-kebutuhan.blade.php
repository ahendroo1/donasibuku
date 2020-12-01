<?php
	$check = DB::table('buku_diterima')->where('id_donasi_item',$kebutuhan->id)->get();
	$kategori_buku_now = DB::table('kategori_buku')->where('id',$kebutuhan->id_kategori_buku)->first();
?>
@if(count($check) > 0)
	<input type="hidden" name="" id="id_now" value="{{count($check)}}">
@else
	<input type="hidden" name="" id="id_now" value="1">
@endif
<div class="col-sm-8">
	<h2 class="pull-left">Daftar Judul Buku Yang Diterima</h2>
	<div class="pull-right">
		<button class="btn btn-default white menu-login custom-menu menu-custom pull-right m-t-10" type="button" onclick="DoAppendBook()">Tambah Judul</button>
	</div>
	<hr class="clear">
	<form method="post" action="{{action("FrontController@postUbahKebutuhan")}}" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="hidden" name="id" value="{{$kebutuhan->id}}" />
		<input type="hidden" name="page" value="{{g('page')}}" />
		<input type="hidden" name="id_kategori_buku" value="{{$kebutuhan->id_kategori_buku}}">
		<div class="m-t-30">
			<div class="form-group form-group-custom" style="margin-top: 18px;">
				<label>Kategori</label>
				<select class="form-control" id="kategori" disabled="">
					<option value="">*Pilih Kategori</option>
					@foreach($kategori_buku as $item)
		    			<option value="{{$item->id}}" {{($kebutuhan->id_kategori_buku == $item->id)?"selected='selected'":""}} >{{$item->nama}}</option>
		    		@endforeach
				</select>
				<hr class="border border-no-padding  m-tb-0">
			</div>
		</div>
		<div class="m-t-40">
			<div id="myList1">
				
			</div>
			<div id="myList2">
				@if(count($check) > 0)
					@foreach($check as $row)
						<div class="new-line-book m-t-40" id="list-{{$row->row}}" class="m-t-30">
							<fieldset class="float-label">
								<input name="judul[]" class="form-control" autocomplete="off" type="text"  required value="{{$row->judul}}"/>
								<label for="username">Judul Buku <span class="green">( Update Judul Buku )</span></label>
								<hr class="border border-no-padding m-tb-0">
							</fieldset>
							<fieldset class="float-label">
								<input name="pengarang[]" class="form-control" autocomplete="off" type="text"  required value="{{$row->penulis}}"/>
								<label for="username">Pengarang <span class="green">( Update Pengarang )</span></label>
								<hr class="border border-no-padding m-tb-0">
							</fieldset>
							<fieldset class="float-label">
								<input name="penerbit[]" class="form-control" autocomplete="off" type="text"  required value="{{$row->penerbit}}"/>
								<label for="username">Penerbit <span class="green">( Update Penerbit )</span></label>
								<hr class="border border-no-padding m-tb-0">
							</fieldset>
							<fieldset class="float-label">
								<input name="qty[]" class="form-control" autocomplete="off" type="text"  required value="{{$row->qty}}"/>
								<label for="username">Quantity <span class="green">( Update Penerbit )</span></label>
								<hr class="border border-no-padding m-tb-0">
							</fieldset>
							<button class="btn btn-default red menu-login custom-menu menu-custom pull-right m-t-10" type="button" onclick="Delete('{{$row->row}}')">Hapus</button>
							<div class="clear"></div>
						</div>
					@endforeach
				@endif
			</div>
			<div class="m-t-30">
		    	<button class="btn btn-default menu-login white" type="submit">Simpan</button>
		    </div>
		</div>
	</form>
</div>
@push('js')
<script type="text/javascript">
	function DoAppendBook(){
		var id_now = $('#id_now').val();
		$("#myList1").prepend('<div class="new-line-book m-t-40" id="list-'+id_now+'" class="m-t-30"><fieldset class="float-label"><input required name="judul[]" class="form-control" autocomplete="off" type="text"  required value="{{$kebutuhan->judul}}"/><label for="username">Judul Buku</label><hr class="border border-no-padding m-tb-0"></fieldset><fieldset class="float-label"><input required name="pengarang[]" class="form-control" autocomplete="off" type="text"  required value="{{$kebutuhan->pengarang}}"/><label for="username">Pengarang</label><hr class="border border-no-padding m-tb-0"></fieldset><fieldset class="float-label"><input required name="penerbit[]" class="form-control" autocomplete="off" type="text"  required value="{{$kebutuhan->penerbit}}"/><label for="username">Penerbit</label><hr class="border border-no-padding m-tb-0"></fieldset><fieldset class="float-label"><input name="qty[]" class="form-control" autocomplete="off" type="text"  required/><label for="username">Quantity</label><hr class="border border-no-padding m-tb-0"></fieldset><button class="btn btn-default red menu-login custom-menu menu-custom pull-right m-t-10" type="button" onclick="Delete('+id_now+')">Hapus</button></div><div class="clear"></div>');
		var now = parseInt($('#id_now').val())+1;
		$('#id_now').val(now);
	}
	function Delete(id_now){
		$( "#list-"+id_now ).remove();
	}
</script>
@endpush