<div class="col-sm-8">
	@if(empty(Request::get('kategori')))
	<h2 class="pull-left">Donasi Sesuai Kategori Buku</h2>
	@else
	<h2 class="pull-left">Pilih TBM </h2>
	<form action="" method="get">
		<div class="group-search pull-right m-t-10">
			<input type="hidden" name="kategori" value="{{Request::get('kategori')}}">
			<input type="text" name="q" class="form-control radius" placeholder="Cari..." value="{{Request::get('q')}}">
			<i class="fas fa-search icon-search"></i>
		</div>
	</form>
	@endif
	<hr class="clear m-tb-0">
	@if(empty(Request::get('kategori')))
	@foreach($kategori as $item)
	<div class="list-buku">
		<div class="title-buku">
			<div class="pull-left">
				<h4>{{$item->nama}}</h4>
			</div>
			<div class="pull-right">
				<a href="?kategori={{$item->id}}" class="btn btn-default custom-menu white">Donasi</a>
			</div>
		</div>
	</div>
	@endforeach
	@else
	<form method="post" action="{{action("FrontController@postDonasiBuku")}}" enctype="multipart/form-data" class="submit-form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="hidden" name="type_donatur" value="kategori" />
	@foreach($req_buku as $item)
	<?php $get_tbm = DB::table('tbm')->where('id',$item->id_tbm)->first(); ?>
	<div class="list-buku">
		<div class="title-buku">
			<div class="pull-left">
				<h4>{{$get_tbm->nama}}</h4>
			</div>
			<div class="pull-right">
				<input type="hidden" name="id_tbm[]" value="{{$get_tbm->id}}" id="id_tbm-{{$get_tbm->id}}{{$item->id}}" disabled="">
				<label class="tasks-list-item">
					<input type="checkbox" name="book_id[]" value="{{$item->id}}" class="tasks-list-cb" id="checkbox_tbm-{{$get_tbm->id}}{{$item->id}}" onclick="DoEnable({{$get_tbm->id}},{{$item->id}})">
					<span class="tasks-list-mark"></span>
				</label>
			</div>
		</div>
		<p>{{$get_tbm->alamat}}</p>
	</div>
	@endforeach
	@if(count($req_buku) > 0)
		<input type="number" name="count-total" value="0" id="count-total" class="hidden">
		<h3>Data Pengirim</h3>
		<div class="form-group form-group-custom m-t-30">
	      <label>Nama Pengirim : </label>
	      <input type="text" name="nama_pengirim" class="form-control form-control-custom" required="">
	    </div>
	    <div class="form-group form-group-custom m-t-30">
	      <label>Nomor Telepon Pengirim : </label>
	      <input type="number" name="no_telp_pengirim" class="form-control form-control-custom" required="">
	    </div>
	    <div class="form-group form-group-custom">
	      <label>Masukan Alamat Pengirim : </label>
	      <input type="text" name="alamat_pengirim" class="form-control form-control-custom" required="">
	    </div>

		<div class="m-t-40">
			<button class="btn btn-default menu-login blue">Donasi</button>
		</div>
	@else
		<div class="m-t-50">
			<center><h4>Tidak Ditemukan permintaan buku dengan kategori yang anda pilih</h4></center>
		</div>
	@endif
	</form>
	{!! urldecode(str_replace("/?","?",$req_buku->appends(Request::all())->render())) !!}

	@endif
</div>
@push('js')
<script type="text/javascript">
	$(function(){
	    $('.submit-form').on('submit', function(event){
	        val = $('#count-total').val();
			if(val == 0){
				swal('Pilih Kategori terlebih dahulu');
				event.preventDefault();
				return false;
			}
	    });
	});
	function DoEnable(id,book){
		if ($("#checkbox_tbm-"+id+book).is(':checked')){
			val = $('#count-total').val();
			total = parseInt(val)+1;
			$('#count-total').val(total);
			document.getElementById('id_tbm-'+id+book).disabled = false;
		}else{
			val = $('#count-total').val();
			total = parseInt(val)-1;
			$('#count-total').val(total);
			document.getElementById('id_tbm-'+id+book).disabled = true;
		}
	}
</script>
@endpush