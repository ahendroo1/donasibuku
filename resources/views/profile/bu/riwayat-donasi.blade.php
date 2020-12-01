<div class="main-sidebar">
	<div class="title">RIWAYAT DONASI</div>
	<div class="border-tbm"><span></span></div>
	<div class="detail">		
		@if ( Session::get('message') != '' )
			<div class='alert alert-warning mb-20'>
				{{ Session::get('message') }}
			</div>	
		@endif				
		<div class="wrapper-loop">
			@foreach($donasi as $item)
				<div class="item">		
					@if($item->status == 'Donasi Belum Lengkap')	
					<?php $link = url('/keranjang/'.$item->no_donasi) ?>
					@else
					<?php $link = url('/donasi-detail/'.$item->no_donasi) ?>
					@endif							
					<a href="{{$link}}">
						<div class="no-donasi">No Donasi : {{$item->no_donasi}}</div>
						<div class="row">
							<div class="col-md-4">
								<div class="attribute">
									Status : {{$item->status}}
								</div>
							</div>
							<div class="col-md-4">
								<div class="attribute">
									Total : {{number_format(total($item->id))}}
								</div>
							</div>
							<div class="col-md-4">
								<div class="attribute">
									Tanggal : {{date('d-m-Y',strtotime($item->tgl_donasi))}}
								</div>
							</div>
						</div>
					</a>
					@if(Session::get('ss_tbm_id') == $item->id_tbm && $item->status != 'Donasi Belum Lengkap')
						<?php $check_konf = DB::table('konfirmasi_donasi')->where('id_donasi',$item->id)->first() ?>
						@if($check_konf)
						<div class="wrap-btn">
							<a href="javascript:void(0);">Sudah Dikonfirmasi</a>
						</div>
						@else
						<div class="wrap-btn">
							<a href="{{url('profile/konfirmasi-pembayaran/'.$item->id)}}">Konfirmasi Pembayaran</a>
						</div>
						@endif
					@endif
				</div>
			@endforeach
		</div>
	</div>	
	<div class="mt-10 wrapper-pagination">
		{!! urldecode(str_replace("/?","?",$donasi->appends(Request::all())->render())) !!}
	</div>
</div>