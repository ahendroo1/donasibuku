@extends('layouts')
@section('content')
<?php
	$instansi = DB::table('instansi')->get();
?>
<div class="container box-container" id="box-container">
	<div class="col-sm-8 col-sm-offset-2">
		<div class="title-register"><h2>Edit Profile Donatur</h2></div>
		<div class="wrapper-register">
			<div class="col-sm-10 col-sm-offset-1">
				<form id="formEditTBM" action="{{action("FrontController@postUpdateDonatur")}}" class="box-form" method="post" enctype="multipart/form-data">	
			      	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="form-edit-profile">
						<h4>Identitas Donatur</h4><br>
						<div class="form-group form-group-custom">
							<label>Nama <span class="required">*</span></label>
							<input name="nama" id="nama" placeholder="Nama"  autocomplete="off" type="text" class="form-control" required value="{{$donatur->nama}}"/>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-group-custom">
									<label>Instansi</label>
									<select class="form-control" name="instansi" id="instansi" style="border-bottom: 1px solid#002BAF;">
										<option value="">Pilih Instansi</option>
										@foreach($instansi as $row)
											<option value="{{$row->name}}" {{($donatur->instansi == $row->name)?'selected="selected"':''}}>{{$row->name}}</option>
										@endforeach
									</select>
									<!-- <hr class="border border-no-padding  m-tb-0"> -->
								</div>
							</div>
						</div>
						<div class="form-group form-group-custom">
							<label>No. Telepon <span class="required">*</span></label>
							<input  name="tlpn" id="tlpn"  autocomplete="off" type="nmber" class="form-control" required value="{{$donatur->tlpn}}"/>
						</div>
						<div class="form-group form-group-custom">
							<label>Alamat <span class="required">*</span></label>
							<input name="alamat" autocomplete="off" type="text" class="form-control" required value="{{$donatur->alamat}}"/>
						</div>
						<div class="form-group form-group-custom">
							<label>Email</label>
							<input name="email" autocomplete="off" type="text" class="form-control disabled" readonly="" required="" value="{{$donatur->email}}"/>
						</div>
						<div class="legend-pengelola">
							<h3>Ubah Sandi</h3>
							<p class="f-grey">Bila tidak merubah kata sandi harap kosongi semua fill di bawah</p>
						</div>
						<div class="form-group form-group-custom">
							<label>Sandi Lama</label>
							<input name="old_password" id="old_password" autocomplete="off" type="password" class="form-control" />
						</div>
						<div class="form-group form-group-custom">
							<label>Sandi Baru</label>
							<input name="new_password" id="new_password" autocomplete="off" type="password" class="form-control" />
						</div>
						<div class="form-group form-group-custom">
							<label for="password">Konfirmasi Sandi</label>
							<input name="conf_password" id="conf_password" autocomplete="off" type="password" class="form-control" />
						</div>
						<div class="row m-t-50">
							<div class="col-sm-12 m-t-30">
								<center><a href="{{url('profile')}}"><button class="btn btn-default menu-login grey" type="button">Kembali</button></a> <button class="btn btn-default menu-login white" type="submit">Simpan</button></center>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection