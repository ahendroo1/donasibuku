@include(header)

<div class="wrapper-on-page">
	<div class="container">
		<div class="frame-white">
			<div class="wrapper-title">
				<div class="row">
					<div class="col-md-9">
						<div class="title">DAFTAR PERMINTAAN BUKU</div>
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

						@if ( Session::get('message') != '' )
						<div class="row mb-20 mt-20">
							<div class="col-md-12">
								<div class='alert alert-warning'>
									{{ Session::get('message') }}
								</div>	
							</div>
						</div>
						@endif

						<div class="right-sidebar">							
							<div class="wrapper-loop">								
								@foreach($kebutuhan as $item)

									@if($item->judul)
										<div class="item">										
											<div class="row">
												<div class="col-md-9"><div class="title">{{$item->judul}}</div></div>
												<div class="col-md-3 ta-right"><a href="{{url('/add-donasi/'.$item->id)}}" class="add-donasi">DONASI</a></div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="attribute">
														<img src="{{asset('assets/img/ic_filter_32x32.png')}}">
														Kategori : {{show_value($item->id_kategori_buku,'kategori_buku','nama')}}
													</div>
												</div>
												<div class="col-md-4">
													<div class="attribute">
														<img src="{{asset('assets/img/ic_list_tb_32x32.png')}}">
														TBM : {{show_value($item->id_tbm,'tbm','nama')}}
													</div>
												</div>
												<div class="col-md-4">
													<div class="attribute harga ta-right">
														Rp {{number_format($item->harga)}}
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="attribute">
														<img src="{{asset('assets/img/ic_penerbit_32x32.png')}}">
														Penerbit : {{$item->penerbit}}
													</div>
												</div>
												<div class="col-md-4">
													<div class="attribute">
														<img src="{{asset('assets/img/ic_toko_32x32.png')}}">
														Store : {{$item->toko_buku}}
													</div>
												</div>
												<div class="col-md-4">
													<div class="attribute ta-right">
														<img src="{{asset('assets/img/ic_penulis_32x32.png')}}">
														Pengarang : {{$item->pengarang}}
													</div>
												</div>
											</div>
										</div>
									@else
										<div class="item">										
											<div class="row">
												<div class="col-md-9"><div class="title">Kategori : {{show_value($item->id_kategori_buku,'kategori_buku','nama')}}</div></div>

												<div class="col-md-3 ta-right"><a href="javascript:void(0);" data-toggle="modal" data-target="#modalMsg" class="add-donasi">DONASI</a></div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="attribute">
														<img src="{{asset('assets/img/ic_list_tb_32x32.png')}}">
														TBM : {{show_value($item->id_tbm,'tbm','nama')}}
													</div>
												</div>
											</div>
										</div>
									@endif
									
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
			{!! urldecode(str_replace("/?","?",$kebutuhan->appends(Request::all())->render())) !!}
		</div>
	</div>
</div>

<div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="modalMsgLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content form">
		<div class="modal-header">
			<a href="javascript:void(0);" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
		</div>
		<div class="modal-body">

			<div class="message">
				Bila Anda Ingin Mendonasikan Buku Berdasarkan Kategori Silahkan Hubungi Forum<br>
				{{get_setting('telepon_forum')}} / {{get_setting('email_forum')}}
			</div>	

		</div>
    </div>
  </div>
</div>
@include(footer)