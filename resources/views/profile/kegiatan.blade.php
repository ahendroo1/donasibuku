<div class="col-sm-8">
	<h2 class="pull-left">Kegiatan TBM</h2>
	
	@if(Session::get('ss_tbm_id') == $tbm->id && Request::segment(1) != 'tbm')
	<a href="{{url('profile/add-kegiatan')}}"><button class="btn btn-default white menu-login custom-menu menu-custom pull-right m-t-10" type="button">Tambah Kegiatan</button></a>
	@endif
	<hr class="clear">
	@if(count($kegiatan) == 0)
	<center>
      <div style="font-size: 50px;">Maaf </div>
      <h4>TBM yang anda pilih, untuk saat ini tidak memiliki daftar kegiatan.</h4>
    </center>
	@endif
	@foreach($kegiatan as $item)
	<div class="list-berita" id="some">
		<div class="berita-img" style="background-image: url('{{asset($item->image)}}');"></div>
		<h3>{{$item->title}}</h3>
		<small class="small">{{date('d M Y',strtotime($item->datetime))}}</small><br><br>
		<p>{!!$item->content!!}</p>
		@php
			$konten=(string)$item->content;
		@endphp

		<button type="button" class="btn btn-default custom-menu white open-modal" data-id="{{$item->id}}">Selengkapnya</button> 
		@if(Request::segment(1) != 'tbm')
		<button type="button" class="btn btn-default custom-menu red" onclick="DoDeDelete({{$item->id}});">Hapus</button>
		@endif
	</div>
	
	@endforeach
	 {!! urldecode(str_replace("/?","?",$kegiatan->appends(Request::all())->render())) !!}
</div>

<div id="modal-detail-keigatan" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div id="img-content">
				{{-- <img src="{{url('assets/bg/bg_daftar_tbm.png')}}" width="30%"> --}}
				
			</div>
			<div class="content-for-modal">
				<div class="col-md-12">
					<h3 id="title-kegiatan"></h3>
					<p><small id="tgl-kegiatan"></small></p>
					<p id="content-kegiatan"></p>
				</div>
			</div>
		</div>
	</div>
</div>
@push('js')
<script type="text/javascript">

	$('.open-modal').on("click",function(){

		data = $(this).attr("data-id");
		
		$('#modal-detail-keigatan').modal('show'); 
		$.get("{{action('FrontController@getDetailKebutuhan')}}/"+data,function(r) {
			
			var urlgambar='{{asset('')}}'+r.image;
			var imgd = '<div style="width: 100%;min-height: 300px;background-image: url({{asset('')}}'+r.image+');" class="modal-img"></div>';
			var img="<div style='height:400px;background-color:#f3f3f3;text-align:center;' >"
			+"<img class='gambar-tengah' height='100%' src="+urlgambar+"></div>";
			var title = r.title; 
			var content = r.content;
			var date = r.datetime;

			$('#img-content').html(img);
			$('#title-kegiatan').html(title);
			$('#tgl-kegiatan').html(date);
			$('#content-kegiatan').html(content);
		});
	});
	function DoRegister(data){
		$('#modal-register').modal('show'); 
		$('#rename-register').html(data);
	}
	function DoDeDelete(id){
		swal({
		  title: "Perhatian",
		  text: "Yakin, menghapus Kegiatan ?",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
		    location.href = "{{url('delete-kegiatan')}}/"+id;
		  }
		});
	}
</script>
@endpush