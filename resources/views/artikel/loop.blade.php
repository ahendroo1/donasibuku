@include(header)
<div class="wrapper-on-page">
	<div class="container">
		<div class="frame-white">
			<div class="title-wrapper"><span>BERITA</span></div>
			<div class="content-wrapper">
				<div class="row">
					<div class="col-md-8 np-right">
						<div class="right-sidebar">
							<div class="wrap-loop">
								@foreach($artikel as $item)
									<div class="item">
										<a href="{{url('artikel/'.$item->slug)}}">
											<div class="row">
												<div class="col-md-4 np-right">
													<div class="image">
														<img src="{{asset($item->image)}}?w=230&h=150">
													</div>
												</div>
												<div class="col-md-8">
													<div class="title">
														{{$item->title}}
													</div>
												</div>
											</div>
										</a>	
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
		<div class="wrapper-pagination">
			{!! urldecode(str_replace("/?","?",$artikel->appends(Request::all())->render())) !!}
		</div>
	</div>
</div>

@include(footer)