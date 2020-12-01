@include(header)

<div class="wrapper-on-page">
	<div class="container">
		<div class="frame-white">
			<div class="wrapper-title">
				<div class="row">
					<div class="col-md-9">
						<div class="title">Daftar Toko Buku</div>
					</div>
					<div class="col-md-3"></div>
				</div>
				<div class="border-tbm">
  					<span></span>
  				</div>
			</div>
			<div class="wrapper-content">
				<div class="wrapper-loop">
					<div class="row">
						@foreach($toko_buku as $item)
						<div class="col-md-4">
							<div class="item">
								<div class="image" style="background-image: url('{{asset($item->image)}}')">
								</div>
								<div class="title">{{$item->nama}}</div>
								<!-- <div class="desk">{{$item->desk}}</div> -->
								<div class="wrap-btn">
									<a href="{{$item->link}}">Menuju Toko</a>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>		
		<div class="wrapper-pagination">
			{!! urldecode(str_replace("/?","?",$toko_buku->appends(Request::all())->render())) !!}
		</div>
	</div>
</div>

@include(footer)