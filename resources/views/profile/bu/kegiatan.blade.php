<div class="main-sidebar">
	<div class="title">{{$tbm->nama}}</div>
	<div class="border-tbm"><span></span></div>
	<div class="detail">		
		@if ( Session::get('message') != '' )
			<div class='alert alert-warning mb-20'>
				{{ Session::get('message') }}
			</div>	
		@endif
		@if(Session::get('ss_tbm_id') == $tbm->id)
		<div class="wrap-btn ta-right">
			<a href="{{url('profile/add-kegiatan')}}" class="btn-add">Tambah Kegiatan</a>
		</div>
		@endif
		<div class="wrapper-loop">
			@foreach($kegiatan as $item)
				<div class="item">
					<div class="title">{{$item->title}}</div>
					<div class="image">
						<img src="{{asset($item->image)}}">
					</div>
				</div>
				@if(Session::get('ss_tbm_id') == $item->id_tbm)
				<div class="wrap-btn">
					<a href="{{url('profile/ubah-kegiatan/'.$item->id)}}">Ubah</a>
					<a href="{{url('delete-kegiatan/'.$item->id)}}">Hapus</a>
				</div>
				@endif
				<div class="border-tbm mb-20 mt-20"><span></span></div>
			@endforeach
		</div>
	</div>	
	<div class="mt-10 wrapper-pagination">
		{!! urldecode(str_replace("/?","?",$kegiatan->appends(Request::all())->render())) !!}
	</div>
</div>