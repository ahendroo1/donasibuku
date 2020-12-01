@include(header)

<div class="wrapper-on-page">
	<div class="container">
		<div class="frame-white">
			<div class="wrapper-title">
				<div class="row">
					<div class="col-md-9">
						<div class="title">DAFTAR TBM</div>
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
							<div class="wrapper-loop tbm-lokasi">
								@foreach($dataLokasi as $item)
									<div class="item">
										<div class="title">
											@if(Request::get('provinsi'))
												<a href="{{url('tbm?provinsi='.Request::get('provinsi').'&kota='.$item->id)}}">{{$item->value}} ({{total_tbm($item->id,'kota')}} TBM)</a>
											@else
												<a href="{{url('tbm?provinsi='.$item->id)}}">{{$item->value}} ({{total_tbm($item->id,'provinsi')}} TBM)</a>
											@endif
										</div>
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
	</div>
</div>

@include(footer)