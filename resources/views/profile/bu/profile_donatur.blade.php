@include('header')
<div class="wrapper-on-page">
	<div class="container">
		<div class="wrapper">
			<div class="row">
				<div class="col-md-4">
					<div class="left-sidebar">
						<!-- <div class="image">
							<img src="{{asset($donatur->image)}}">
						</div> -->
						<div class="menu">
							<ul>
								<li>
									<a href="{{url('/profile')}}" class="{{($slug=='')?'active':''}}">
										Profile
									</a>
								</li>
								<li>
									<a href="{{url('/profile/riwayat-donasi')}}" class="{{($slug=='riwayat-donasi')?'active':''}}">
										Riwayat Donasi
									</a>
								</li>
								<li>
									<a href="{{url('/logout')}}">
										Logout
									</a>
								</li>
							</ul>
						</div>
						<a href="{{url('profile/edit')}}" class="tbm-btn">
						Edit Profile
						</a>
					</div>
				</div>
				<div class="col-md-8">
					@if($slug != '')
						@include('profile.'.$slug)
					@else
						<div class="main-sidebar">
							<div class="title">
								@if($donatur->nama)
								{{$donatur->nama}}
								@else
								Mohon Untuk Melengkapi Data
								@endif
							</div>
							<div class="border-tbm"><span></span></div>
							<div class="detail">
								<div class="row">
									<div class="col-md-3">
										<label>Instansi</label>
									</div>
									<div class="col-md-9">{{$donatur->instansi}}</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Alamat</label>
									</div>
									<div class="col-md-9">{{$donatur->alamat}}</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>No Telepon</label>
									</div>
									<div class="col-md-9">{{$donatur->tlpn}}</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Email</label>
									</div>
									<div class="col-md-9">{{$donatur->email}}</div>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@include('footer')