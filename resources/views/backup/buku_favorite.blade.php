@include(header)

<div class="wrapper-on-page wrapper-buku-favorite">
	<div class="container">
		<div class="frame-white">
			<div class="wrapper-title">
				<div class="row">
					<div class="col-md-9">
						<div class="title">BUKU FAVOURITE</div>
					</div>
					<div class="col-md-3"></div>
				</div>
				<div class="border-tbm">
  					<span></span>
  				</div>
			</div>
			<div class="wrapper-content wrapper">
				<div class="wrapper-loop content-wrapper">
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
			</div>
		</div>		
		<div class="wrapper-pagination">
			{!! urldecode(str_replace("/?","?",$buku_favorite->appends(Request::all())->render())) !!}
		</div>
	</div>
</div>

@include(footer)