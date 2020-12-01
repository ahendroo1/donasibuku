<div class="main-sidebar">
	<div class="title">{{$tbm->nama}}</div>
	<div class="border-tbm"><span></span></div>
	<div class="detail">
		<div class="row">
			<div class="col-md-3">
				<label>Ketua</label>
			</div>
			<div class="col-md-3">{{$tbm->nama_ketua}}</div>
			<div class="col-md-3">
				<label>Email</label>
			</div>
			<div class="col-md-3">{{$tbm->email_pengelola}}</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<label>Tempat Lahir</label>
			</div>
			<div class="col-md-3">{{$tbm->tempat_lahir_pengelola}}</div>
			<div class="col-md-3">
				<label>Tanggal Lahir</label>
			</div>
			<div class="col-md-3">{{$tbm->tanggal_lahir_pengelola}}</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<label>Kode Pos</label>
			</div>
			<div class="col-md-9">
				{{$tbm->kodepos_pengelola}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<label>Alamat</label>
			</div>
			<div class="col-md-9">
				{{$tbm->alamat_pengelola}}
			</div>
		</div>
	</div>
</div>