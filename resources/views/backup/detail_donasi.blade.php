@include(header)

<div class="wrapper-on-page">
	<div class="container">
		<div class="frame-white">
			<div class="title-wrapper ta-left"><span>{{$donasi->no_donasi}}</span></div>
			<div class="content-wrapper">	
				<div class="row">
					<div class="col-md-8">
						<div class="right-sidebar">
							<div class="user-detail">
								<div class="form-group">
									<label>Nama Lengkap</label>
									<div>{{$donasi->nama}}</div>
								</div>
								<div class="form-group">
									<label>No Telepon</label>
									<div>{{$donasi->tlpn}}</div>
								</div>
								<div class="form-group">
									<label>Email</label>
									<div>{{$donasi->email}}</div>
								</div>
							</div>
							<div class="bank">
								<div class="form-group">
									<label>Bank Yang Dituju :</label>
								</div>
								<div class="wrap-loop-bank">
									<div class="item">
										<label>
											<div class="row">
												<div class="col-md-12">
													<div class="detail">
														<div class="norek">{{$donasi->bank}}</div>
													</div>
												</div>
											</div>
										</label>
									</div>
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
										{{number_format(total($donasi->id))}}
									</div>
								</div>
							</div>
							<div class="border-tbm"><span></span></div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

@include(footer)