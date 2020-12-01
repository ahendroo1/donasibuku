<div class="main-sidebar">
	<div class="title">{{$donatur->nama}}</div>
	<div class="border-tbm"><span></span></div>
	<div class="detail">
		@if ( Session::get('message') != '' )
			<div class='alert alert-warning mb-20'>
				{{ Session::get('message') }}
			</div>	
		@endif
		<div class="wrapper-form">	
			<div class="title">
				<div class="ta-center">Konfirmasi Pembayaran</div>
			</div>
			<div class="desk">
				<p>No Donasi : {{$donasi->no_donasi}}</p>
				<p>Total : {{number_format(total($donasi->id))}}</p>
			</div>
			<form method="post" action="{{action("FrontController@postAddKonfimasiPembayaran")}}" enctype="multipart/form-data">
			    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			    <input type="hidden" name="id" value="{{$donasi->id}}" />
			    <div class="form-group">
			    	<label>Transfer Ke Bank</label>
			    	<p>{{$donasi->bank}}</p>
			    	<!-- <select class="form-control" name="id_bank">
			    		<option value="">- Pilih Bank -</option>
			    		@foreach($bank as $item)
			    			<option value="{{$item->id}}">{{$item->bank.', An : '.$item->an.', Norek : '.$item->norek}}</option>
			    		@endforeach
			    	</select> -->
			    </div>
  				<div class="legend-pengelola mb-20">
      				<div class="title">Tranfer Dari Akun Bank</div>
      				<div class="border-tbm">
      					<span></span>
      				</div>
      			</div>
			    <div class="form-group">
			    	<label>Bank</label>
			    	<input type="text" name="bank" class="form-control" placeholder="Bank">
			    </div>
			    <div class="form-group">
			    	<label>Atas Nama</label>
			    	<input type="text" name="an" class="form-control" placeholder="Atas Nama">
			    </div>
			    <div class="form-group">
			    	<label>No Rekening</label>
			    	<input type="text" name="norek" class="form-control" placeholder="No Rekening">
			    </div>
			    <div class="form-group">
			    	<label>Nominal</label>
			    	<p style="font-size: 24px;font-weight: bold">{{number_format(total($donasi->id))}}</p>
			    </div>
			    <div class="wrap-btn ta-center">
			    	<a href="{{url('profile/riwayat-donasi')}}">Kembali</a>
			    	<input type="submit" value="Simpan">
			    </div>
			</form>
		</div>
	</div>	
</div>