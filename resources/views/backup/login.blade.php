@include('header')
<div class="wrapper-on-page">
	<div class="wrapper-login" style="background-image: url('{{asset("assets/img/bg-login.png")}}')">
		<div class="container">
			<div class="frame-login">
				<div class="row">
					<div class="col-md-7 np-right">
						<div class="image hm">
							<img src="{{asset("assets/img/image-login.png")}}">
						</div>
					</div>
					<div class="col-md-5 np-left">
						<div class="wrapper-form">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active"><a href="#TBM" aria-controls="TBM" role="tab" data-toggle="tab">TBM</a></li>
								<li role="presentation"><a href="#donatur" aria-controls="donatur" role="tab" data-toggle="tab">DONATUR</a></li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="TBM">
									<div class="form">
										<form action="{{action("FrontController@postLoginTbm")}}" method="post">
		      								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
											<input type="email" name="email" placeholder="Email" />
											<input type="password" name="password" placeholder="Password" />
											<input type="submit" value="MASUK" class="tbm-btn"/>
											<div class="atau">
												<span>ATAU</span>
												<span class="border"></span>
											</div>
											<a href="{{url('/register')}}" class="tbm-btn">DAFTAR</a>
											<a href="javascript:void(0);" data-toggle="modal" data-target="#modalLupaSandi" class="lupa-sandi">Lupa Sandi ?</a>
										</form>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade" id="donatur">									
									<div class="form">
										<form action="{{action("FrontController@postLoginDonatur")}}" method="post">
		      								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
											<input type="email" name="email" placeholder="Email" />
											<input type="password" name="password" placeholder="Password" />
											<input type="submit" value="MASUK" class="tbm-btn"/>
											<div class="atau">
												<span>ATAU</span>
												<span class="border"></span>
											</div>
											<a href="javascript:void(0);" class="tbm-btn" data-toggle="modal" data-target="#modalRegDonatur">DAFTAR</a>
											<a href="javascript:void(0);" data-toggle="modal" data-target="#modalLupaSandiDon" class="lupa-sandi">Lupa Sandi ?</a>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalRegDonatur" tabindex="-1" role="dialog" aria-labelledby="modalRegDonaturLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content form">
		<form method="post" action="{{action("FrontController@postRegisterDonatur")}}">
		    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="title">
					<div>Segera</div>
					<div><span>Daftarkan</span></div>
				</div>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-md-3">
						<label>Email</label>
					</div>
					<div class="col-md-9">
						<input type="email" name="email" id="email" placeholder="Email" class="form-control" />
						<p class="tbm-help hidden">Pastikan email yang anda masukan benar</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<label>Password</label>
					</div>
					<div class="col-md-9">
						<input type="password" name="password" id="password" placeholder="Password" class="form-control" />
					</div>
				</div>

				<div class="border-tbm"><span></span></div>
  				<div class="mt-10">
  					<label>
  						<input type="checkbox" name="confirm_data" value="1">
  						Saya menyatakan data yang saya masukan adalah benar.!
  					</label>
  				</div>

			</div>
			<div class="modal-footer">
				<input type="submit" value="DAFTARKAN" class="tbm-btn">
			</div>
		</form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalLupaSandi" tabindex="-1" role="dialog" aria-labelledby="modalLupaSandiLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content form">
		<form method="post" action="{{action("FrontController@postLupaSandi")}}">
		    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="title">
					<div>Lupa</div>
					<div><span>Sandi</span></div>
				</div>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-md-3">
						<label>Email</label>
					</div>
					<div class="col-md-9">
						<input type="email" name="email" id="email" placeholder="Email" class="form-control" />
						<p class="tbm-help hidden">Pastikan email yang anda masukan benar</p>
					</div>
				</div>

				<div class="border-tbm"><span></span></div>

			</div>
			<div class="modal-footer">
				<input type="submit" value="KIRIM" class="tbm-btn">
			</div>
		</form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalLupaSandiDon" tabindex="-1" role="dialog" aria-labelledby="modalLupaSandiDonLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content form">
		<form method="post" action="{{action("FrontController@postLupaSandiDon")}}">
		    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="title">
					<div>Lupa</div>
					<div><span>Sandi</span></div>
				</div>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-md-3">
						<label>Email</label>
					</div>
					<div class="col-md-9">
						<input type="email" name="email" id="email" placeholder="Email" class="form-control" />
						<p class="tbm-help hidden">Pastikan email yang anda masukan benar</p>
					</div>
				</div>

				<div class="border-tbm"><span></span></div>

			</div>
			<div class="modal-footer">
				<input type="submit" value="KIRIM" class="tbm-btn">
			</div>
		</form>
    </div>
  </div>
</div>

@if ( Session::get('message') != '' )
	<!-- Modal -->
	<div class="modal fade in" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="modalMsgLabel" style="display:block;">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content form">
			<div class="modal-header">
				<a href="{{url('/login')}}"><span aria-hidden="true">&times;</span></a>
			</div>
			<div class="modal-body">

				<div class="message">{!! Session::get('message') !!}</div>	

			</div>
	    </div>
	  </div>
	</div>
	<div class="modal-backdrop fade in"></div>
@endif
@include('footer')