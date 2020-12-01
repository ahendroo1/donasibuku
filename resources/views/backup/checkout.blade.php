@include(header)

<div class="wrapper-on-page">
	<div class="container">
		<div class="frame-white">
			<div class="title-wrapper ta-left"><span>CHECKOUT DONASI</span></div>
			<div class="content-wrapper">	
				@if ( Session::get('message') != '' )
					<div class='alert alert-warning mb-20'>
						{{ Session::get('message') }}
					</div>	
				@endif
				<form method="post" action="{{action("FrontController@postCheckout")}}">
				    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="row">
						<div class="col-md-8">
							<div class="right-sidebar">
								<div class="user-detail">
									<div class="form-group">
										<label>Nama Lengkap</label>
										<input type="text" name="nama" value="{{$donatur->nama}}">
									</div>
									<div class="form-group">
										<label>No Telepon</label>
										<input type="text" name="tlpn" value="{{$donatur->tlpn}}">
									</div>
									<div class="form-group">
										<label>Email</label>
										<input type="email" name="email" value="{{$donatur->email}}">
									</div>
								</div>
								<div class="bank">
									<div class="form-group">
										<label>Pilih Bank Yang Dituju :</label>
									</div>
									<div class="wrap-loop-bank">
										@foreach($bank as $item)
											<div class="item">
												<label>
													<input type="radio" name="id_bank" value="{{$item->id}}" class="hidden">
													<div class="row">
														<div class="col-md-3">
															<div class="image">
																<img src="{{asset($item->image)}}">
															</div>
														</div>
														<div class="col-md-9">
															<div class="detail">
																<div class="norek">No Rekening : {{$item->norek}}</div>
																<div class="an">An : {{$item->an}}</div>
																<div class="cabang">Cabang : {{$item->cabang}}</div>
															</div>
														</div>
													</div>
												</label>
											</div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="ringkasan-donasi">
								<div class="title-dongker">RINGKASAN DONASI</div>
								<div class="content">
									@foreach($donasi_item as $item)
										<div class="item">
											<div class="title">{{$item->judul}}</div>
											<div class="desk">
												<span class="qty">QTY : {{$item->qty}}</span>
												<span class="harga">Harga : {{number_format($item->harga)}}</span>
											</div>
											<div class="total">Total : {{number_format($item->qty*$item->harga)}}</div>
										</div>
									@endforeach
								</div>
								<div class="subtotal">
									<div class="row">
										<div class="col-md-5 label-subtotal np-right">
											Subtotal
										</div>
										<div class="col-md-7 nominal">
											{{number_format(total(Session::get('ss_id_donasi')))}}
										</div>
									</div>
								</div>
								<div class="border-tbm"><span></span></div>
							</div>
						</div>
					</div>
					<div class="wrap-btn ta-center">
						<a href="{{url('/keranjang')}}">Kembali</a>
						<input type="submit" value="Selesai">
					</div>
				</form>	
			</div>
		</div>	
	</div>
</div>

@include(footer)