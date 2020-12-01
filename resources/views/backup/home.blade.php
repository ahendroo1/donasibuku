@include(header)
<div class="wrapper-slider">
	<div id="tbmSlider" class="owl-carousel">
		@foreach ($slider as $item)
		<a href="{{ $item->link }}"> 
        	<div class="item cursor-pointer" style="background-image: url('{{ $item->image }}')" >
        	</div>
        </a>
        @endforeach
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
	      $("#tbmSlider").owlCarousel({

		      navigation : false,
		      autoPlay : 5000,
		      slideSpeed : 300,
		      paginationSpeed : 400,
		      singleItem : true

	      });
	    });
	</script>
</div>
<div class="container">
	<div class="wrapper-search">
		<form method="post" action="{{action("FrontController@postSearch")}}">			
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="wrapper">
				<div class="wrapper-input">
					<input type="text" name="s" placeholder="Cari Kebutuhan Buku">
				</div>
				<div class="wrapper-btn">
					<input type="submit" value="CARI">
				</div>
			</div>
		</form>
	</div>
	<div class="wrapper-berita">
		<div class="wrapper">
			<div class="title-wrapper"><span>BERITA</span></div>
			<div class="content-wrapper">
				<div class="row hm">
					<div class="col-md-8 np-right">
						<div class="item main">
							<a href="{{url('/artikel/'.$artikel_big->slug)}}">
								<div class="img" style="background-image: url('{{asset($artikel_big->image)}}?h=470')"></div>
								<div class="caption">
									<div class="caption-inner">{{$artikel_big->title}}</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="sidebar-berita">
							<div class="title">BERITA TERKINI</div>
							<div class="content">
								<?php $i=1 ?>
								@foreach($artikel_terkini as $item)
									@if($i != 1)
										<div class="item {{($i==3 || $i==5)?'gray':''}}">
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
									@endif
								<?php $i++ ?>
								@endforeach
							</div>
						</div>
					</div>
				</div>
				<div class="list-news">
					<div class="row hm">
						<?php $ii=1 ?>
						@foreach($artikel as $item)
							<?php if(!in_array($ii,array(1,2,3,4,5))){ ?>
								<div class="col-md-4 np-all">
									<div class="item">
										<a href="{{url('/artikel/'.$item->slug)}}">
											<div class="image" style="background-image: url('{{asset($item->image)}}?h=335&w=525')"></div>
											<div class="caption">
												<div class="caption-inner">
													<div>{{$item->title}}</div>
													<span></span>
												</div>
											</div>
										</a>
									</div>
								</div>
							<?php } ?>
							<?php $ii++ ?>
						@endforeach
					</div>
					<div class="row hd">
						<?php $ii=1 ?>
						@foreach($artikel as $item)
							<?php if(!in_array($ii,array(7,8,9,10,11))){ ?>
								<div class="col-md-4 np-all">
									<div class="item">
										<a href="{{url('/artikel/'.$item->slug)}}">
											<div class="image" style="background-image: url('{{asset($item->image)}}?h=335&w=525')"></div>
											<div class="caption">
												<div class="caption-inner">
													<div>{{$item->title}}</div>
													<span></span>
												</div>
											</div>
										</a>
									</div>
								</div>
							<?php } ?>
							<?php $ii++ ?>
						@endforeach
					</div>
				</div>
			</div>
			<div class="wrap-btn ta-center">
				<a href="{{url('artikel')}}" class="tbm-btn btn-o">LIHAT LEBIH BANYAK</a>
			</div>
		</div>
	</div>
	<div class="wrapper-berita wrapper-buku-favorite">
		<div class="wrapper">
			<div class="title-wrapper"><span>BUKU FAVORITE</span></div>
			<div class="content-wrapper">
				<div class="row">
					@foreach($buku_favorite as $item)
						<div class="col-md-3">
							<div class="item">
								<div class="image">
									<img src="{{asset($item->image)}}">
								</div>
								<div class="caption fadeIn animated">
									<div class="title">{{$item->judul}}</div>
									<div class="wrap-btn">
										<a href="{{$item->link}}">Menuju ke Toko</a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<div class="wrap-btn ta-center">
				<a href="{{url('buku-favorite')}}" class="tbm-btn btn-o">LIHAT LEBIH BANYAK</a>
			</div>
		</div>
	</div>
</div>

@if ( Session::get('message') != '' )
	<!-- Modal -->
	<div class="modal fade in" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="modalMsgLabel" style="display:block;">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content form">
			<div class="modal-header">
				<a href="{{url('/')}}"><span aria-hidden="true">&times;</span></a>
			</div>
			<div class="modal-body">

				<div class="message">{!! Session::get('message') !!}</div>	

			</div>
	    </div>
	  </div>
	</div>
	<div class="modal-backdrop fade in"></div>
@endif
@include(footer)