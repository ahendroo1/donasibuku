@include(header)

<div class="wrapper-on-page">
	<div class="container">
		<div class="frame-white">
			<div class="wrapper-title">
				<div class="row">
					<div class="col-md-9">
						<div class="title">DAFTAR PENDONATUR</div>
					</div>
					<div class="col-md-3"></div>
				</div>
				<div class="border-tbm">
  					<span></span>
  				</div>
			</div>
			<div class="wrapper-content">

				<div class="row">
					<div class="col-md-8 np-right">
						<div class="right-sidebar">							
							<div class="wrapper-loop">
								@foreach($donatur as $item)
									<div class="item">
										<div class="title">{{($item->nama)?$item->nama:$item->email}}</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
					<div class="col-md-4">
						@include(sidebar)
					</div>
				</div>

			</div>
		</div>		
		<div class="wrapper-pagination">
			{!! urldecode(str_replace("/?","?",$donatur->appends(Request::all())->render())) !!}
		</div>
	</div>
</div>

@include(footer)