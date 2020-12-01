@include('header')
<div class="wrapper-on-page">
	<div class="container">
		<div class="wrapper frame-white">
			<div class="title-artikel">{{$page->title}}</div>
			<div class="main-artikel">
				<div class="row">
					<div class="col-md-8 np-right">
						<div class="right-sidebar">
							<div class="content">
								<div class="desk font-roboto">{!!$page->content!!}</div>
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

@include('footer')