@include('header')
<div class="wrapper-on-page">
	<div class="container">
		<div class="wrapper frame-white">
			<div class="title-artikel">{{$artikel->title}}</div>
			<div class="date-artikel">{{get_dateformat($artikel->created_at,'sort')}}</div>
			<div class="main-artikel">
				<div class="row">
					<div class="col-md-8 np-right">
						<div class="right-sidebar">
							<div class="content">
								<div class="image-artikel">
									<img src="{{asset($artikel->image)}}">
								</div>
								<div class="desk font-roboto">{!!$artikel->content!!}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('footer')