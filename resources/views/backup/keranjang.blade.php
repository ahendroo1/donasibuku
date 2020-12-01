@include(header)

<div class="wrapper-on-page">
	<div class="container">
		<div class="frame-white">
			<div class="title-wrapper ta-left"><span>KERANJANG DONASI</span></div>
			@if(!$donasi_item)			
			<div class="row mb-20 mt-20">
				<div class="col-md-12">
					<div class='alert alert-warning'>
						Keranjang kosong silahkan pilih buku untuk di Donasi, <a href="{{url('/daftar-buku')}}">Klik disini untuk melihat Daftar Buku</a>
					</div>	
				</div>
			</div>
			@else
			<div class="content-wrapper">	
				<form method="post" action="{{action("FrontController@postUpdateDonasiItem")}}">
				    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="wrapper-loop">
						@foreach($donasi_item as $item)						
							<div class="item">	
								<div class="row">
									<div class="col-md-12"><div class="title">{{$item->judul}}</div></div>
								</div>									
								<div class="row">
									<div class="col-md-10 np-right">
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
									<div class="col-md-2">
										<div class="qty ta-center attribute">
											QTY : <input type="number" name="qty[]" min="1" max="100" value='{{$item->qty}}'>
											<input type="hidden" name="id[]" value='{{$item->id}}'>
										</div>
										<div class="wrap-btn ta-center">
											<a href="{{url('/delete-donasi-item/'.$item->id)}}">
												<img src="{{asset('assets/img/ic_trash_32x32.png')}}">
											</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
					<div class="ta-right">
						<input type="submit" value="Ubah" class="btn-ubah-keranjang">
					</div>
				</form>	
				<div class="subtotal">
					<div class="row">
						<div class="col-md-2 label-subtotal np-right">
							Subtotal
						</div>
						<div class="col-md-10 nominal">
							{{number_format(total(Session::get('ss_id_donasi')))}}
						</div>
					</div>
				</div>
				<div class="border-tbm"><span></span></div>
			</div>
			@endif
		</div>	
		@if($donasi_item)
		<div class="btn-lanjutkan">
			<a href="{{url('/checkout')}}">Lanjutkan</a>
		</div>
		@endif
	</div>
</div>

@include(footer)