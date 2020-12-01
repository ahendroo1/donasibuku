<div class="col-sm-8">
	<h2 class="pull-left">Pilih TBM</h2>
	<form action="" method="get">
		<div class="group-search pull-right m-t-10">
			<input type="hidden" name="kategori" value="{{Request::get('kategori')}}">
			<input type="text" name="q" class="form-control radius" placeholder="Cari..." value="{{Request::get('q')}}">
			<i class="fas fa-search icon-search"></i>
		</div>
	</form>
	<hr class="clear m-tb-0">
	<form method="post" action="{{action("FrontController@postDonasiBuku")}}" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="hidden" name="type_donatur" value="kategori" />
	@foreach($tbm as $item)
	<div class="list-buku">
		<div class="title-buku">
			<div class="pull-left">
				<h4>{{$item->nama}}</h4>
			</div>
			<div class="pull-right">
				<input type="hidden" name="id_tbm[]" value="{{$item->id}}" id="id_tbm-{{$item->id}}" disabled="">
				<label class="tasks-list-item">
					<input type="checkbox" name="book_id[]" value="{{$item->id}}" class="tasks-list-cb" id="checkbox_tbm-{{$item->id}}" onclick="DoEnable({{$item->id}})">
					<span class="tasks-list-mark"></span>
				</label>
			</div>
		</div>
		<p>{{$item->alamat}}</p>
	</div>
	@endforeach
	<div class="m-t-40">
		<button class="btn btn-default menu-login blue">Donasi</button>
	</div>
	</form>
</div>
@push('js')
<script type="text/javascript">
	function DoEnable(id){
		if ($("#checkbox_tbm-"+id).is(':checked')){
			document.getElementById('id_tbm-'+id).disabled = false;
		}else{
			document.getElementById('id_tbm-'+id).disabled = true;
		}
	}
</script>
@endpush