<?php 
	$artikel   = DB::table('artikel')->orderBy('id','DESC')->paginate(4);
	$toko_buku = DB::table('toko_buku')->orderBy('id','DESC')->paginate(4);
?>

<div class="right-sidebar hm">	
	<div class="wrapper-forum-tbm wrapper-sidebar">
		<div class="bg-dongker title">FORUM TBM</div>
		<div class="content">
			<div class="image">
				<a href="http://forumtbm.or.id/">
					<img src="{{asset('assets/img/forumtbm.png')}}">
				</a>
			</div>
			<div class="desk">
				Kompleks Hegar Alam 40, Ciloang <br>
				Kota Serang, Banten - 42118 <br>
				Telp: (0254) 202 861 <br>
				Email: forumtbm@gmail.com
			</div>
		</div>
	</div>					
	<div class="berita-terkini wrapper-sidebar">
		<div class="bg-dongker title">BERITA TERKINI</div>
		<div class="content">
			<?php $i =1; ?>
			@foreach($artikel as $item)
			<div class="item {{($i==2 || $i==4)?'gray':''}}">
				<a href="{{url('/artikel/'.$item->slug)}}">
					<div class="row">
						<div class="col-md-4 np-right">
							<div class="img" style="background-image: url('{{asset($item->image)}}?w=125&h=110')"></div>
						</div>
						<div class="col-md-8">
							<div class="title-news">{{str_limit($item->title,50)}}</div>
						</div>
					</div>
				</a>
			</div>
			<?php $i++; ?>
			@endforeach
		</div>
	</div>					
	<div class="buku-terfavorit wrapper-sidebar">
		<div class="bg-dongker title">Toko Buku</div>
		<div class="content">
			<?php $i =1; ?>
			@foreach($toko_buku as $item)
			<div class="item {{($i==2 || $i==4)?'gray':''}}">
				<a href="{{url($item->link)}}">
					<div class="row">
						<div class="col-md-4 np-right">
							<div class="img" style="background-image: url('{{asset($item->image)}}?w=125&h=110')"></div>
						</div>
						<div class="col-md-8">
							<div class="title-news">{{str_limit($item->nama,50)}}</div>
						</div>
					</div>
				</a>
			</div>
			<?php $i++; ?>
			@endforeach
		</div>
	</div>
</div>